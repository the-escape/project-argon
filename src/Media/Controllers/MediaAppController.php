<?php

namespace Escape\Argon\Media\Controllers;

use Escape\Argon\Core\Controllers\BaseController;
use Escape\Argon\Media\Eloquent\MediaFolderRepository;
use Escape\Argon\Media\Eloquent\MediaItem;
use Escape\Argon\Media\Eloquent\MediaItemRepository;
use Escape\Argon\Media\Helpers\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use stdClass;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Response;
use View;
use Image;
use Input;

class MediaAppController extends BaseController
{

    public function app()
    {
        return View::make('argon::media.app');
    }

    public function folders($id=null)
    {
        $media_folders = DB::table("media_folders")->whereNull('deleted_at')->get();

        if (is_null($id))
        {
            if (request()->query->has("debug"))
            {
                echo "\n\n<pre>" . print_r($media_folders, TRUE) . "</pre>\n\n"; exit;
            }

            return response()->json($media_folders);
        }

        $folder = [];

        foreach ($media_folders as $media_folder)
        {
            if ($media_folder->id == $id)
            {
                $folder = $media_folder;
                $folder->children = Media::treeLevel($media_folders, $id, 3);
                $folder->items = [];
                break;
            }
        }

        if ($folder)
        {
            $media_items = DB::table("media_items")->whereNull('deleted_at')->get();
            $folder = Media::addItems($folder, $media_items);
        }

        if (request()->query->has("debug"))
        {
            echo "\n\n<pre>" . print_r($folder, TRUE) . "</pre>\n\n"; exit;
        }

        return response()->json($folder);
    }

    public function search($keywords="")
    {
        $items = [];

        if ($keywords === '')
        {
            return response()->json($items);
        }

        $like = "%{$keywords}%";
        $items = DB::table("media_items")->where('filename', 'like', $like)->whereNull('deleted_at')->get();

        // TODO: Perhaps fuzzy search here

        if (request()->query->has("debug"))
        {
            echo "\n\n<pre>" . print_r($items, TRUE) . "</pre>\n\n"; exit;
        }

        return response()->json($items);
    }

    public function recent(MediaItemRepository $itemRepository)
    {
        $items = $itemRepository->orderBy('updated_at', 'desc')->paginate(config('argon.medialibrary.recent_items', 30));

        return response()->json($items);
    }

    public function folderAdd(Request $request, MediaFolderRepository $folderRepository)
    {
        if ($folderRepository->folderExists($request->input('name'), $request->input('parent')))
        {
            return response()->json(['error' => 'Folder exists.'], Response::HTTP_CONFLICT);
        }

        $folder = $folderRepository->create($request->input());

        return response()->json($folder);
    }

    public function folderEdit(Request $request, MediaFolderRepository $folderRepository)
    {
        $folder = $folderRepository->findWhere(['id' => $request->input('folder')])->first();

        if (!$folder)
        {
            return response()->json(['error' => "Folder `{$request->input('folder')}` doesn't exists."], Response::HTTP_BAD_REQUEST);
        }

        $folder->name = $request->input('name');
        $folder->save();

        return response()->json($folder);
    }

    public function folderRemove (
        Request $request,
        MediaFolderRepository $folderRepository,
        MediaItemRepository $itemRepository
    ) {
        $folderId = (preg_match('/^[1-9][0-9]*$/', $request->input('id'))) ? (int)$request->input('id') : null;

        if (!$folderId)
        {
            return response()->json(["error" => "Invalid folder `$folderId`."], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($folderId === 1)
        {
            return response()->json(["error" => "Root folder can't be removed."], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($itemRepository->getItemsInFolder($folderId)->count() > 0 || $folderRepository->getSubfolders($folderId)->count() > 0)
        {
            return response()->json(["error" => "Folder not empty."], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $deleted = $folderRepository->delete($folderId);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    public function upload(Request $request, MediaFolderRepository $folderRepository)
    {
        $folderId = $request->request->get('folder');

        $folder = $folderRepository->findWhere(['deleted_at' => null, 'id' => $folderId])->first();

        if ($folder === null)
        {
            return response()->json(['error' => "Folder `$folderId` doesn't exists."], Response::HTTP_BAD_REQUEST);
        }

        $files = $request->file('files');

        if (empty($files[0]))
        {
            return response()->json(['error' => "No file(s) selected for upload."], Response::HTTP_BAD_REQUEST);
        }

        $userId = $request->user()->id;

        $mediaRepository = app()->make(MediaItemRepository::class);

        $msgErrors = [];
        $msgSuccess = [];
        $fileIds = [];

        foreach ($files as $file)
        {
            if ($file->getError() !== 0)
            {
                $msgErrors[] = $file->getErrorMessage();
                continue;
            }

            $r = Media::saveUploadedFile($file, $folder->getId(), $userId, $mediaRepository);
            $msgSuccess[] = "File '{$file->getClientOriginalName()}'was uploaded successfully as '{$r->getFullName()}'";
            $fileIds[] = $r->id;
        }

        if ($msgErrors)
        {
            $messageCombined = [];

            foreach ($msgErrors as $msg)
            {
                $messageCombined[] = $msg;
            }

            if ($msgSuccess)
            {
                foreach ($msgSuccess as $msg)
                {
                    $messageCombined[] = $msg;
                }
            }

            return response()->json(["messages" => $messageCombined, "fileIDs" => []], Response::HTTP_NO_CONTENT);
        }

        //return redirect(route("cms:media:modal:all", ['order=uploaded_at&dir=desc']))->with('message', implode('<br>', $msgSuccess));
        return response()->json(["messages" => $msgSuccess, "fileIDs" => $fileIds], Response::HTTP_OK);
    }

    public function deleteItem(Request $request, MediaItemRepository $itemRepository)
    {
        $itemId = (preg_match('/^[1-9][0-9]*$/', $request->request->get('id'))) ? (int)$request->request->get('id') : null;

        if (!$itemId)
        {
            return response()->json(["error" => "Invalid media item `$itemId`."], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // TODO: implement graceful handling of fetching images in blade withohut exceprtions/interruptions
        $item = $itemRepository->findWhere(["id" => $itemId])->first();

        if (!$item)
        {
            return response()->json(['error' => "Media item `$itemId` doesn't exists."], Response::HTTP_BAD_REQUEST);
        }

        $deleted = $itemRepository->delete($itemId);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    public function delete(Request $request, MediaItemRepository $itemRepository, MediaFolderRepository $folderRepository)
    {
        $folders = $request->get('folders', []);
        $items = $request->get('items', []);
        $deletedFolders = [];
        $deletedItems = [];

        if (!empty($items))
        {
            if (!is_array($items))
            {
                $items = [$items];
            }

            foreach($items as $itemId)
            {
                if ($item = $itemRepository->findWhere(["id" => $itemId])->first())
                {
                    // todo: check if can be deleted

                    $canBeDeleted = !$this->deleteItemCheck($itemId, $itemRepository);

                    // mark as deleted if exists and can be deleted
                    if ($canBeDeleted && $itemRepository->delete($itemId))
                    {
                        $deletedItems[] = $itemId;
                    }
                }
                else
                {
                    // or if doesn't exist anymore
                    $deletedItems[] = $itemId;
                }
            }
        }

        if (!empty($folders))
        {
            if (!is_array($folders))
            {
                $folders = [$folders];
            }

            foreach($folders as $folderId)
            {
                // root folder can't be deleted
                if ($folderId !== 1)
                {
                    // check if folder still exists
                    if ($folder = $folderRepository->findWhere(['deleted_at' => null, 'id' => $folderId])->first())
                    {
                        // delete if folder is empty
                        if ($itemRepository->getItemsInFolder($folderId)->count() === 0 && $folderRepository->getSubfolders($folderId)->count() === 0)
                        {
                            if ($folderRepository->delete($folderId))
                            {
                                $deletedFolders[] = $folderId;
                            }
                        }
                    }
                    else
                    {
                        // mark as deleted if already doesn't exist
                        $deletedFolders[] = $folderId;
                    }
                }
            }
        }

        // sending back IDs of folders/items that could not be deleted
        return response()->json([
            "folders" => array_diff($folders, $deletedFolders),
            "items" => array_diff($items, $deletedItems)
        ]);
    }

    public function move(Request $request, MediaItemRepository $itemRepository, MediaFolderRepository $folderRepository)
    {
        $itemIds = $request->request->get('items');
        $folderIds = $request->request->get('folders');

        if(!is_array($itemIds))
        {
            $itemIds = [$itemIds];
        }

        if(!is_array($folderIds))
        {
            $folderIds = [$folderIds];
        }

        if(!count($itemIds) && !count($folderIds))
        {
            return response()->json(["error" => "No Items or fields received"], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $items = $itemRepository->findWhereIn("id", $itemIds);
        $folders = $folderRepository->findWhereIn("id", $folderIds);

        if(!count($items) && !count($folders))
        {
            return response()->json(['error' => "Media items or Folders don't exist."], Response::HTTP_BAD_REQUEST);
        }

        $destinationFolderId = $request->request->get('destinationFolder');
        $destinationFolder = $folderRepository->findWhere(['deleted_at' => null, 'id' => $destinationFolderId])->first();

        if($destinationFolder === null)
        {
            return response()->json(['error' => "Destination Folder `$destinationFolderId` doesn't exist."], Response::HTTP_BAD_REQUEST);
        }

        foreach($items as $item){
            $item->folder = $destinationFolder->id;
            $saved = $item->save();
        }

        foreach($folders as $folder){
            $folder->parent = $destinationFolder->id;
            $saved = $folder->save();
        }

        return response()->json([], Response::HTTP_NO_CONTENT);
    }

    public function update(Request $request, MediaItem $mediaItem, MediaFolderRepository $folderRepository)
    {
        $mediaItemID = $request->request->get('mediaID');

        $mediaItem = $mediaItem->find($mediaItemID);

        if (!$mediaItem)
        {
            abort(404);
        }

        $name = $request->input('name');

        if($name){
            $mediaItem->filename = $name;
        }

        $file = $request->file('file');

        if (!$file)
        {
            if($name)
            {
                $mediaItem->save();
                return response()->json(['messages' => 'File name successfully changed to '.$name], Response::HTTP_OK);
            }
            else
            {
                return response()->json(['errors' => "No file was recieved"], Response::HTTP_BAD_REQUEST);
            }
        }

        $isImage =  Media::isImage($file->getMimeType());

        $tmpPath = $request->file('file')->getRealPath();

        $meta = new stdClass();

        if ($isImage)
        {
            list($meta->width, $meta->height) = @getimagesize($tmpPath);
        }

        $mediaItem->extension = $file->getClientOriginalExtension();
        $mediaItem->filesize = $file->getSize();
        $mediaItem->mimetype = $file->getClientMimeType();
        $mediaItem->meta = json_encode($meta);
        $mediaItem->uploaded_by = $request->user()->id;
        $mediaItem->save();

        $disk = Storage::disk('media');
        $disk->makeDirectory($mediaItem->id);

        $fileHandle = fopen($tmpPath, 'r+');

        Storage::disk('media')->put(
            "{$mediaItem->id}/{$mediaItem->getSlug()}.{$file->getClientOriginalExtension()}",
            $fileHandle
        );

        fclose($fileHandle);

        // Thumbnail images
        if ($isImage)
        {
            $thumb = Image::make($file)->fit(100, 100);

            Storage::disk('media')->put(
                "{$mediaItem->id}/{$mediaItem->id}.thumb.{$file->getClientOriginalExtension()}",
                $thumb->encode()
            );

            $mediaItem->hasThumb = true;
            $mediaItem->save();
        }

        return response()->json(["messages" => "successfully updated ".$name], Response::HTTP_OK);
    }
}
