<?php

namespace Escape\Argon\Media\Controllers;

use Escape\Argon\Core\Controllers\BaseController;
use Escape\Argon\Media\Eloquent\MediaFolderRepository;
use Escape\Argon\Media\Eloquent\MediaItemRepository;
use Illuminate\Http\Request;
use Storage;
use Symfony\Component\HttpFoundation\Response;
use View;
use Image;
use Input;

class MediaController extends BaseController
{
    protected $imageFormats = [
	"image/jpg",
	"image/png",
	"image/gif"
    ];

    public function manage(MediaFolderRepository $folderRepository)
    {
        $media = [];

        $root = $folderRepository->root();

        return View::make('argon::media.manage', ['media' => $media, 'root' => $root]);
    }

    public function items(MediaItemRepository $mediaRepository)
    {
        $folderId = Input::get('folderId');
        $items = $mediaRepository->getItemsInFolder($folderId);

        return response()->json($items);
    }

    public function upload(Request $request, MediaItemRepository $mediaRepository)
    {
        $folderId = Input::get('current-folder');
        $file = $request->file('file');

        $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        while ($mediaRepository->itemExists($name, $folderId)) {

            if (preg_match('/(.*) \((\d+)\)/', $name, $matches)) {
            $name = $matches[1];
            $count = $matches[2];
            }
            else
            {
            $count = 1;
            }

            $count++;

            $name = sprintf('%s (%d)', $name, $count);
        }

        $mediaItem = $mediaRepository->create([
            'folder' => $folderId,
            'filename' => $name,
            'extension' => $file->getClientOriginalExtension(),
            'filesize' => $file->getSize(),
            'mimetype' => $file->getMimeType(),
            'meta' => json_encode(new \stdClass()),
            'uploaded_by' => $request->user()->id,
        ]);

        $disk = Storage::disk('media');

        $disk->makeDirectory($mediaItem->id);
        $fileHandle = fopen($request->file('file')->getRealPath(), 'r+');
        Storage::disk('media')->put("{$mediaItem->id}/{$mediaItem->id}.original.{$file->getClientOriginalExtension()}", $fileHandle);
        fclose($fileHandle);

        // Thumbnail images

        if (in_array($file->getMimeType(), $this->imageFormats)) {
            $thumb = Image::make($file)->fit(100, 100);
            Storage::disk('media')->put("{$mediaItem->id}/{$mediaItem->id}.thumb.{$file->getClientOriginalExtension()}", $thumb->encode());

            $mediaItem->hasThumb = true;
            $mediaItem->save();
        }

        return response()->json($mediaItem, Response::HTTP_CREATED);
    }

    public function deleteItem($id, MediaItemRepository $itemRepository)
    {
        $itemRepository->delete($id);

        return response('', Response::HTTP_NO_CONTENT);
    }

    public function createFolder(Request $request, MediaFolderRepository $folderRepository)
    {
        if (!$folderRepository->folderExists($request->input('name'), $request->input('parent'))) {
            $folder = $folderRepository->create($request->input());

            return response()->json($folder);
        } else {
            return response()->json(['error' => 'folder exists'], 409);
        }
    }

    public function deleteFolder($folderId, MediaFolderRepository $folderRepository, MediaItemRepository $itemRepository)
    {
        if ($itemRepository->getItemsInFolder($folderId)->count() > 0) {
            return response()->json(['error' => 'Folder not empty.'], 409);
        } else {
            $folderRepository->delete($folderId);

            return response('', 204);
        }
    }

    public function itemDetails($itemId, MediaItemRepository $itemRepository)
    {
        $item = $itemRepository->find($itemId);

        return response()->json($item);
    }

}
