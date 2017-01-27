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

        $meta = new stdClass();

        if ($isImage)
        {
            list($meta->width, $meta->height) = @getimagesize($tmpPath);
        }

        $mediaItem = $mediaRepository->create([
            'folder' => $folderId,
            'filename' => $name,
            'extension' => $file->getClientOriginalExtension(),
            'filesize' => $file->getSize(),
            'mimetype' => $file->getClientMimeType(),
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
        $results = $this->deleteItemCheck($id, $itemRepository);

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

    private function deleteItemCheck($id, MediaItemRepository $itemRepository)
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

        return $results;
    }

    public function createFolder(Request $request, MediaFolderRepository $folderRepository)
    {
        if (!$folderRepository->folderExists($request->input('name'), $request->input('parent'))) {
            $folder = $folderRepository->create($request->input());

            return response()->json($folder);
        } else {
            return response()->json(['error' => 'folder exists'], Response::HTTP_CONFLICT);
        }
    }

    public function deleteFolder(
        $folderId,
        MediaFolderRepository $folderRepository,
        MediaItemRepository $itemRepository
    ) {
        if ($itemRepository->getItemsInFolder($folderId)->count() > 0) {
            return response()->json(['error' => 'Folder not empty.'], Response::HTTP_CONFLICT);
        } else {
            $folderRepository->delete($folderId);

            return response('', Response::HTTP_NO_CONTENT);
        }
    }

    public function itemDetails($itemId, MediaItemRepository $itemRepository)
    {
        $item = $itemRepository->find($itemId);
        $item->meta = json_decode($item->meta);
        $item->filesize_formatted = $item->getFriendlyFilesize();
        return response()->json($item);
    }

    private function getOrder($query, Request $request)
    {
        $dir = (in_array($request->input('dir'), ['asc', 'desc'])) ? $request->input('dir') : 'asc';

        switch ($request->input('order'))
        {
            case 'id':
                $query = $query->with('mediaFolder');
                $query = $query->orderBy('id', $dir);
                break;

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
                $query = $query->join('media_folders', 'media_items.folder', '=', 'media_folders.id');
                $query = $query->select('media_items.*');
                $query = $query->orderBy('media_folders.name', $dir);
                break;

            default:
                throw new RuntimeException('Unknown order argument!');
        }

        return $query;
    }

    public function all(Request $request, MediaItem $mediaItem)
    {
        $query = $mediaItem->whereNull('media_items.deleted_at');

        if ($request->has('order'))
        {
            $query = $this->getOrder($query, $request);
        }

        $perPage = $request->input('perpage', 20);

        $media = $query->paginate($perPage);

        return View::make('argon::media.list', [
            'media' => $media,
            'request' => $request,
        ]);
    }

    public function modalAll(Request $request, MediaItem $mediaItem)
    {
        $query = $mediaItem->whereNull('media_items.deleted_at');

        if ($request->has('order'))
        {
            $query = $this->getOrder($query, $request);
        }

        $perPage = $request->input('perpage', 20);

        $media = $query->paginate($perPage);

        return View::make('argon::media.modal.list', [
            'media' => $media,
            'request' => $request,
        ]);
    }


    public function folders(MediaFolderRepository $folderRepository)
    {
        $root = $folderRepository->root();

        return View::make('argon::media.folders', ['root' => $root]);
    }


    public function modalFolders(MediaFolderRepository $folderRepository)
    {
        $root = $folderRepository->root();

        return View::make('argon::media.modal.folders', ['root' => $root]);
    }


    public function edit($id, MediaItem $mediaItem, MediaFolderRepository $folderRepository)
    {
        $media = $mediaItem->with('mediaFolder')->find($id);

        if (!$media)
        {
            abort(404);
        }

        $currentFolder = $folderRepository->findWhere(['deleted_at' => null, 'id'=>$media->getParentId()])->first();

        if ($currentFolder === null)
        {
            throw new RuntimeException("No folder with ID: '{$id}'. Perhaps soft deleted?");
        }

        $root = $folderRepository->root();

        return View::make('argon::media.edit', [
            'media' => $media,
            'root' => $root,
            'currentFolder' => $currentFolder,
        ]);
    }


    public function modal_edit($id, MediaItem $mediaItem, MediaFolderRepository $folderRepository)
    {
        $media = $mediaItem->with('mediaFolder')->find($id);

        if (!$media)
        {
            abort(404);
        }

        $currentFolder = $folderRepository->findWhere(['deleted_at' => null, 'id'=>$media->getParentId()])->first();

        if ($currentFolder === null)
        {
            throw new RuntimeException("No folder with ID: '{$id}'. Perhaps soft deleted?");
        }

        $root = $folderRepository->root();

        return View::make('argon::media.modal.edit', [
            'media' => $media,
            'root' => $root,
            'currentFolder' => $currentFolder,
        ]);
    }


    public function update($id, MediaItem $mediaItem, MediaFolderRepository $folderRepository, Request $request)
    {
        $media = $mediaItem->find($id);

        if (!$media)
        {
            abort(404);
        }

        $name = $request->input('name', '');
        $parentId = $request->input('parent');

        $parent = $folderRepository->findWhere(['deleted_at' => null, 'id'=>$parentId])->first();

        if ($parent === null)
        {
            throw new RuntimeException("Parent folder is required!");
        }

        $media->folder = $parent->getId();
        $media->save();

        return redirect(route("cms:media:edit", $id))->with('message', 'Media item updated!');
    }


    public function modal_update($id, MediaItem $mediaItem, MediaFolderRepository $folderRepository, Request $request)
    {
        $media = $mediaItem->find($id);

        if (!$media)
        {
            abort(404);
        }

        $name = $request->input('name', '');
        $parentId = $request->input('parent');

        $parent = $folderRepository->findWhere(['deleted_at' => null, 'id'=>$parentId])->first();

        if ($parent === null)
        {
            throw new RuntimeException("Parent folder is required!");
        }

        $media->folder = $parent->getId();
        $media->save();

        return redirect(route("cms:media:modal:edit", $id))->with('message', 'Media item updated!');
    }


//    public function delete($id, MediaItem $mediaItem)
//    {
//        $media = $mediaItem->with('mediaFolder')->find($id);
//
//        if (!$media)
//        {
//            abort(404);
//        }
//
//        throw new RuntimeException('Not implemented');
//    }


    public function delete($id, MediaItemRepository $itemRepository)
    {
        $results = $this->deleteItemCheck($id, $itemRepository);

        if ($results)
        {
//            $stop=1;
//            return response()->json([
//                'error' => 'Could not delete, media item in use:',
//                'results' => $results,
//            ], Response::HTTP_OK);

            $message = ["Could not delete, media item in use:"];

            foreach($results as $i => $result)
            {
                $message[] = "(".($i+1).") Type: {$result->entity_type}, Name:  {$result->entity_name}, Locale: {$result->locale_name} (Entity ID: {$result->entity_id})";
            }

            return back()
                ->with('message', implode(PHP_EOL, $message))
                ->with('results', $results);
        }

        $stop=1;
        $itemRepository->delete($id);

        return back()
            ->with('message', 'Media item deleted!');

//        return redirect(route("cms:media:modal:all"));
        //return response('', Response::HTTP_NO_CONTENT);

//        return response()->json([
//            'error' => '',
//            'results' => '',
//        ], Response::HTTP_OK);
    }


    public function modal_delete($id, MediaItemRepository $itemRepository)
    {
        $results = $this->deleteItemCheck($id, $itemRepository);
        if ($results)
        {
//            $stop=1;
//            return response()->json([
//                'error' => 'Could not delete, media item in use:',
//                'results' => $results,
//            ], Response::HTTP_OK);


            $message = ["Could not delete, media item in use:"];

            foreach($results as $i => $result)
            {
                $message[] = "(".($i+1).") Type: {$result->entity_type}, Name:  {$result->entity_name}, Locale: {$result->locale_name} (Entity ID: {$result->entity_id})";
            }

            return back()
                ->with('message', implode(PHP_EOL, $message))
                ->with('results', $results);
        }

        $stop=1;
        $itemRepository->delete($id);

        return back()
            ->with('message', 'Media item deleted!');

//        $media = $mediaItem->with('mediaFolder')->find($id);
//
//        if (!$media)
//        {
//            abort(404);
//        }
//
//        throw new RuntimeException('Not implemented');
    }


    public function search(Request $request, MediaItem $mediaItem)
    {
        $query = $mediaItem;

        if ($request->has('order'))
        {
            $query = $this->getOrder($query, $request);
        }

        $query = $query->where(function ($query) use ($request) {
            $query
                ->where('filename', 'like', '%' . $request->input('keywords') . '%')
                ->orWhere('extension', 'like', '%' . $request->input('keywords') . '%')
                ->orWhere('mimetype', 'like', '%' . $request->input('keywords') . '%')
                ->orWhereHas('mediaFolder', function($q) use($request) {
                    $q->where('name', 'like', '%'.$request->input('keywords').'%')->whereNull('deleted_at');
                });
        });

        $media = $query->get();

        return View::make('argon::media.search', [
            'media' => $media,
            'request'=>$request,
        ]);
    }


    public function modal_search(Request $request, MediaItem $mediaItem)
    {
        $query = $mediaItem;

        if ($request->has('order'))
        {
            $query = $this->getOrder($query, $request);
        }

        $query = $query->where(function ($query) use ($request) {
            $query
                ->where('filename', 'like', '%' . $request->input('keywords') . '%')
                ->orWhere('extension', 'like', '%' . $request->input('keywords') . '%')
                ->orWhere('mimetype', 'like', '%' . $request->input('keywords') . '%')
                ->orWhereHas('mediaFolder', function($q) use($request) {
                    $q->where('name', 'like', '%'.$request->input('keywords').'%')->whereNull('deleted_at');
                });
        });

        $media = $query->get();

        return View::make('argon::media.modal.search', [
            'media' => $media,
            'request'=>$request,
        ]);
    }


    public function upload_get(Request $request, MediaFolderRepository $mediaFolderRepository)
    {
        $folders = $mediaFolderRepository->all();

        return View::make('argon::media.upload', [
            'folders' => $folders,
        ]);
    }


    public function modal_upload_get(Request $request, MediaFolderRepository $mediaFolderRepository)
    {
        $folders = $mediaFolderRepository->all();

        return View::make('argon::media.modal.upload', [
            'folders' => $folders,
        ]);
    }


    public function modal_upload_post(Request $request)
    {
        $folderId = Input::get('folder');

        $files = $request->file('file');

        if ($files)
        {
            $userId = $request->user()->id;

            $mediaRepository = app()->make(MediaItemRepository::class);

            foreach ($files as $file)
            {
                $r = Media::saveUploadedFile($file, $folderId, $userId, $mediaRepository);
            }
        }

        return redirect(route("cms:media:modal:all"));
    }


    public function upload_post(Request $request)
    {
        $folderId = Input::get('folder');

        $files = $request->file('file');

        if ($files)
        {
            $userId = $request->user()->id;

            $mediaRepository = app()->make(MediaItemRepository::class);

            foreach ($files as $file)
            {
                $r = Media::saveUploadedFile($file, $folderId, $userId, $mediaRepository);
            }
        }

        return redirect(route("cms:media:all"));
    }


    public function modal_folderAdd($id, Request $request, MediaFolderRepository $folderRepository)
    {
        $parentFolder = $folderRepository->findWhere(['deleted_at' => null, 'id'=>$id])->first();

        if ($parentFolder === null)
        {
            throw new RuntimeException("No folder with ID: '{$id}'. Perhaps soft deleted?");
        }

        $folders = $folderRepository->findWhere(['deleted_at' => null]);

        $root = $folderRepository->root();

        return View::make('argon::media.modal.folder-add', [
            'parentFolder' => $parentFolder,
            'folders' => $folders,
            'root' => $root,
        ]);

    }


    public function folderAdd($id, Request $request, MediaFolderRepository $folderRepository)
    {
        $parentFolder = $folderRepository->findWhere(['deleted_at' => null, 'id'=>$id])->first();

        if ($parentFolder === null)
        {
            throw new RuntimeException("No folder with ID: '{$id}'. Perhaps soft deleted?");
        }

        $folders = $folderRepository->findWhere(['deleted_at' => null]);

        $root = $folderRepository->root();

        return View::make('argon::media.folder-add', [
            'parentFolder' => $parentFolder,
            'folders' => $folders,
            'root' => $root,
        ]);

    }


    public function modal_folderSave(MediaFolderRepository $folderRepository, Request $request)
    {
        $parent = $folderRepository->findWhere(['deleted_at' => null, 'id'=>$request->input('parent')])->first();

        if ($parent === null)
        {
            return redirect(route("cms:media:modal:folders"))->with('message', "Parent folder is required!");
        }

        $name = $request->input('name');

        if (trim($name) == '')
        {
            return redirect(route("cms:media:modal:folders"))->with('message', "Folder name can't be empty");
        }

        if ($folderRepository->folderExists($request->input('name'), $request->input('parent')))
        {
            return redirect(route("cms:media:modal:folders"))->with('message', "Folder already exists!");
        }

        $folder = $folderRepository->create($request->input());

        return redirect(route("cms:media:modal:folders:edit", $folder->getId()))->with('message', 'Folder created!');
    }


    public function folderSave(MediaFolderRepository $folderRepository, Request $request)
    {
        $parent = $folderRepository->findWhere(['deleted_at' => null, 'id'=>$request->input('parent')])->first();

        if ($parent === null)
        {
            return redirect(route("cms:media:folders"))->with('message', "Parent folder is required!");
        }

        $name = $request->input('name');

        if (trim($name) == '')
        {
            return redirect(route("cms:media:folders"))->with('message', "Folder name can't be empty");
        }

        if ($folderRepository->folderExists($request->input('name'), $request->input('parent')))
        {
            return redirect(route("cms:media:folders"))->with('message', "Folder already exists!");
        }

        $folder = $folderRepository->create($request->input());

        return redirect(route("cms:media:folders:edit", $folder->getId()))->with('message', 'Folder created!');
    }


    public function modal_folderEdit($id, MediaFolderRepository $folderRepository)
    {
        $currentFolder = $folderRepository->findWhere(['deleted_at' => null, 'id'=>$id])->first();
        
        if ($currentFolder === null)
        {
            throw new RuntimeException("No folder with ID: '{$id}'. Perhaps soft deleted?");
        }
        
        if ($currentFolder->getid() === 1)
        {
            return redirect(route("cms:media:folders"))->with('message', "Root folder can't be changed!");
        }

        $folders = $folderRepository->findWhere(['deleted_at' => null, ['id', '!=', $id]]);

        $root = $folderRepository->root();

        return View::make('argon::media.modal.folder-edit', [
            'currentFolder' => $currentFolder,
            'folders' => $folders,
            'root' => $root,
        ]);
    }


    public function folderEdit($id, MediaFolderRepository $folderRepository)
    {
        $currentFolder = $folderRepository->findWhere(['deleted_at' => null, 'id'=>$id])->first();

        if ($currentFolder === null)
        {
            throw new RuntimeException("No folder with ID: '{$id}'. Perhaps soft deleted?");
        }

        if ($currentFolder->getid() === 1)
        {
            return redirect(route("cms:media:folders"))->with('message', "Root folder can't be changed!");
        }

        $folders = $folderRepository->findWhere(['deleted_at' => null, ['id', '!=', $id]]);

        $root = $folderRepository->root();

        return View::make('argon::media.folder-edit', [
            'currentFolder' => $currentFolder,
            'folders' => $folders,
            'root' => $root,
        ]);
    }


    public function modal_folderUpdate($id, MediaFolderRepository $folderRepository, Request $request)
    {
        $currentFolder = $folderRepository->findWhere(['deleted_at' => null, 'id'=>$id])->first();

        if ($currentFolder === null)
        {
            throw new RuntimeException("No folder with ID: '{$id}'. Perhaps soft deleted?");
        }

        $name = $request->input('name', '');
        $parent = $request->input('parent');

        if (trim($name) == '')
        {
            return redirect(route("cms:media:modal:folders:edit", $id))->with('message', "Folder name can't be empty");
        }
        
        $currentFolder = $folderRepository->update(['name' => $name, 'parent'=>$parent], $id);

        return redirect(route("cms:media:modal:folders:edit", $id))->with('message', 'Folder updated!');
    }


    public function folderUpdate($id, MediaFolderRepository $folderRepository, Request $request)
    {
        $currentFolder = $folderRepository->findWhere(['deleted_at' => null, 'id'=>$id])->first();

        if ($currentFolder === null)
        {
            throw new RuntimeException("No folder with ID: '{$id}'. Perhaps soft deleted?");
        }

        $name = $request->input('name', '');
        $parent = $request->input('parent');

        if (trim($name) == '')
        {
            return redirect(route("cms:media:folders:edit", $id))->with('message', "Folder name can't be empty");
        }

        $currentFolder = $folderRepository->update(['name' => $name, 'parent'=>$parent], $id);

        return redirect(route("cms:media:folders:edit", $id))->with('message', 'Folder updated!');
    }


    public function modal_folderRemove(
        $folderId,
        MediaFolderRepository $folderRepository,
        MediaItemRepository $itemRepository,
        Request $request
    ) {
        if ($folderId == 1)
        {
            return redirect(route("cms:media:modal:folders"))->with('message', "Root folder can't be removed!");
        }

        // TODO: getItemsInFolder needs to be recursive as it fails currently
        // if child folder has items so they are not direcly under the folder being deleted
        if ($itemRepository->getItemsInFolder($folderId)->count() > 0)
        {
            return redirect(route("cms:media:modal:folders"))->with('message', "Folder not empty!");
        }

        $folderRepository->delete($folderId);

        return redirect(route("cms:media:modal:folders"))->with('message', "Folder deleted!");
    }


    public function folderRemove(
        $folderId,
        MediaFolderRepository $folderRepository,
        MediaItemRepository $itemRepository,
        Request $request
    ) {
        if ($folderId == 1)
        {
            return redirect(route("cms:media:folders"))->with('message', "Root folder can't be removed!");
        }

        // TODO: getItemsInFolder needs to be recursive as it fails currently
        // if child folder has items so they are not direcly under the folder being deleted
        if ($itemRepository->getItemsInFolder($folderId)->count() > 0)
        {
            return redirect(route("cms:media:folders"))->with('message', "Folder not empty!");
        }

        $folderRepository->delete($folderId);

        return redirect(route("cms:media:folders"))->with('message', "Folder deleted!");
    }


    public function folderParentUpdate($id, $parentId, MediaFolderRepository $folderRepository)
    {

        $parent = $folderRepository->findWhere(['deleted_at' => null, 'id'=>$parentId])->first();

        if ($parent === null)
        {
            throw new RuntimeException("Parent folder is required!");
        }


        $currentFolder = $folderRepository->findWhere(['deleted_at' => null, 'id'=>$id])->first();

        if ($currentFolder === null)
        {
            throw new RuntimeException("No folder with ID: '{$id}'. Perhaps soft deleted?");
        }

        $currentFolder = $folderRepository->update(['parent'=>$parentId], $id);

        return json_encode(['success'=>true]);

    }


    public function itemParentUpdate($id, $parentId, MediaItem $mediaItem, MediaFolderRepository $folderRepository)
    {
        $parent = $folderRepository->findWhere(['deleted_at' => null, 'id'=>$parentId])->first();

        if ($parent === null)
        {
            throw new RuntimeException("Parent folder is required!");
        }

        $media = $mediaItem->find($id);

        if (!$media)
        {
            abort(404);
        }

        $media->folder = $parent->getId();
        $media->save();

        return json_encode(['success'=>true]);
    }

}
