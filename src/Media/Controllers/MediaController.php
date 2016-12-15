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
use Symfony\Component\HttpFoundation\Response;
use View;
use Image;
use Input;

class MediaController extends BaseController
{


    public function manage(MediaFolderRepository $folderRepository)
    {
        $media = [];

        $root = $folderRepository->root();

        return View::make('argon::media.manage', ['media' => $media, 'root' => $root]);
    }

    public function browse(MediaFolderRepository $folderRepository)
    {
        $media = [];

        $root = $folderRepository->root();

        return View::make('argon::media.browser', ['media' => $media, 'root' => $root]);
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

        if (!$file)
        {
            return response()->json(null, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        
        $name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        while ($mediaRepository->itemExists($name, $folderId))
        {
            if (preg_match('/(.*) \((\d+)\)/', $name, $matches))
            {
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

        $isImage =  Media::isImage($file->getMimeType());

        $tmpPath = $request->file('file')->getRealPath();

        $meta = new \stdClass();

        if ($isImage)
        {
            list($meta->width, $meta->height) = @getimagesize($tmpPath);
        }

        $mediaItem = $mediaRepository->create([
            'folder' => $folderId,
            'filename' => $name,
            'extension' => $file->getClientOriginalExtension(),
            'filesize' => $file->getSize(),
            'mimetype' => $file->getMimeType(),
            'meta' => json_encode($meta),
            'uploaded_by' => $request->user()->id,
        ]);

        $disk = Storage::disk('media');
        $disk->makeDirectory($mediaItem->id);
        $fileHandle = fopen($tmpPath, 'r+');
        Storage::disk('media')->put(
            "{$mediaItem->id}/{$mediaItem->id}.original.{$file->getClientOriginalExtension()}",
            $fileHandle
        );
        fclose($fileHandle);

        // Thumbnail images
        if ($isImage) {
            $thumb = Image::make($file)->fit(100, 100);
            Storage::disk('media')->put(
                "{$mediaItem->id}/{$mediaItem->id}.thumb.{$file->getClientOriginalExtension()}",
                $thumb->encode()
            );

            $mediaItem->hasThumb = true;
            $mediaItem->save();
        }

        return response()->json($mediaItem, Response::HTTP_CREATED);
    }

    public function deleteItem($id, MediaItemRepository $itemRepository)
    {
        $sql = "select
                entity_localisations.entity_id,
                entity_localisations.id as localisation_id,
                field_data.entity_revision_id as revision_id,
                field_data.id as data_id,
                field_data.value as data_value,
                locales.name as locale_name,
                entities.name as entity_name,
                entity_types.type as entity_type,
                entity_fields.field_type
                from `field_data`
                inner join entity_revisions on entity_revisions.id = field_data.entity_revision_id
                inner join entity_fields on entity_fields.id = field_data.field_id
                inner join `entity_localisations` on `entity_localisations`.`id` = `entity_revisions`.`entity_localisation_id`
                inner join `locales` on `locales`.`id` = `entity_localisations`.`locale_id`
                inner join `entities` on `entities`.`id` = `entity_localisations`.`entity_id`
                inner join `entity_types` on `entity_types`.`id` = `entities`.`entity_type_id`
                where 1
                and `field_data`.`value` LIKE ?
                and `entity_revisions`.`status` in (1,2)
                and `entity_fields`.`field_type` in ('image', 'file', 'combo')
                and `entity_localisations`.`deleted_at` is null
                and `entity_fields`.`deleted_at` is null
                group by entity_revisions.entity_localisation_id";

        $results = DB::select(DB::raw($sql), ['%"'.$id.'"%']);

        foreach ($results as $i => &$result)
        {
            if ($result->field_type == 'combo')
            {
                // validate combo subfields to see if subfield with matching value is image/file field type
                $comboFields = json_decode($result->data_value, true);

                $valid = false;

                foreach ($comboFields as $instance => $subfields)
                {
                    foreach ($subfields['fields'] as $fid => $fval)
                    {
                        foreach ($fval as $value)
                        {
                            if (strpos($value, $id) !== false)
                            {
                                // select field type to check if image/file
                                $sql = "select `field_type`, `name` as 'field_name' from `entity_fields`
                                        where 1
                                        and `id` = ?
                                        and `deleted_at` is null";

                                $r = DB::select(DB::raw($sql), [$fid]);

                                if ($r)
                                {
                                    foreach ($r as $subfield)
                                    {
                                        if (in_array($subfield->field_type, ['image', 'file']))
                                        {
                                            $valid = true;
                                            $result->{$fid} = $subfield;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }

                if (!$valid)
                {
                    unset($results[$i]);
                }
            }
        }

        if ($results)
        {
            return response()->json([
                'error' => 'Could not delete, media item in use:',
                'results' => $results,
            ], Response::HTTP_OK);
        }

        $itemRepository->delete($id);

        //return response('', Response::HTTP_NO_CONTENT);

        return response()->json([
            'error' => '',
            'results' => '',
        ], Response::HTTP_OK);
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

    public function deleteFolder(
        $folderId,
        MediaFolderRepository $folderRepository,
        MediaItemRepository $itemRepository
    ) {
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
        $item->meta = json_decode($item->meta);
        $item->filesize_formatted = $item->getFriendlyFilesize();
        return response()->json($item);
    }


    public function all(Request $request, MediaItem $mediaItem)
    {
        $query = $mediaItem;

        if ($request->has('order'))
        {
            $dir = (in_array($request->input('dir'), ['asc', 'desc'])) ? $request->input('dir') : 'asc';

            switch ($request->input('order'))
            {
                case 'name':
                    $query = $query->with('mediaFolder');
                    $query = $query->orderBy('filename', $dir);
                    break;

                case 'extension':
                    $query = $query->with('mediaFolder');
                    $query = $query->orderBy('extension', $dir);
                    break;

                case 'uploaded_at':
                    $query = $query->with('mediaFolder');
                    $query = $query->orderBy('created_at', $dir);
                    break;

                case 'size':
                    $query = $query->with('mediaFolder');
                    $query = $query->orderBy('filesize', $dir);
                    break;

                case 'folder':
                    $query = $query->with(['mediaFolder' => function($q) use ($dir) {
                        $q->orderBy('name', $dir);
                    }]);
                    break;

                case 'width':
                case 'height':
                $query = $query->with('mediaFolder');
                    dd('TODO');
                    break;

                default:
                    throw new RuntimeException('Unknown order argument!');
            }
        }

        $media = $query->get();

        return View::make('argon::media.list', [
            'media' => $media,
            'request' => $request,
        ]);
    }


    public function folders(MediaItem $mediaItem)
    {
        $media = $mediaItem->with('mediaFolder')->get();

        return View::make('argon::media.folders', [
            'media' => $media,
        ]);
    }


    public function edit($id, MediaItem $mediaItem, MediaFolderRepository $mediaFolderRepository)
    {
        $media = $mediaItem->with('mediaFolder')->find($id);

        if (!$media)
        {
            abort(404);
        }

        $folders = $mediaFolderRepository->all();

        return View::make('argon::media.edit', [
            'media' => $media,
            'folders' => $folders,
        ]);
    }


    public function update($id, MediaItem $mediaItem)
    {
        $media = $mediaItem->with('mediaFolder')->find($id);

        if (!$media)
        {
            abort(404);
        }

        throw new \Exception('Not implemented');
    }


    public function delete($id, MediaItem $mediaItem)
    {
        $media = $mediaItem->with('mediaFolder')->find($id);

        if (!$media)
        {
            abort(404);
        }

        throw new \Exception('Not implemented');
    }


    public function search(Request $request, MediaItem $mediaItem)
    {
        $media = $mediaItem
            ->whereNull('deleted_at')
            ->where(function ($query) use ($request) {
                $query
                    ->where('filename', 'like', '%' . $request->input('keywords') . '%')
                    ->orWhere('extension', 'like', '%' . $request->input('keywords') . '%')
                    ->orWhere('mimetype', 'like', '%' . $request->input('keywords') . '%')
                    ->orWhereHas('mediaFolder', function($q) use($request) {
                        $q->where('name', 'like', '%'.$request->input('keywords').'%')->whereNull('deleted_at');
                    });
            })
            ->get();

        return View::make('argon::media.search', [
            'media' => $media,
            'request'=>$request,
        ]);
    }



}
