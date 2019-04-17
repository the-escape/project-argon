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
                entity_fields.field_type,
                entity_fields.name as field_name,
                entity_fields.id as field_id
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
                        if (is_array($fval))
                        {
                            foreach ($fval as $value)
                            {
                                if (is_array($value) && array_key_exists('id', $value))
                                {
                                    $value = $value['id'];
                                }
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
                        else
                        {
                            if (strpos($fval, $id) !== false)
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
            elseif (in_array($result->field_type, ['image', 'file']))
            {
                $fields = json_decode($result->data_value, true);

                foreach ($fields as $field) {
                    if (isset($field['id']) && $field['id'] == $id || $field == $id)
                    {
                        $subfield = new \stdClass();
                        $subfield->field_type = $result->field_type;
                        $subfield->field_name = $result->field_name;

                        $valid = true;
                        $result->{$id} = $subfield;
                    }
                }

                if (!$valid)
                {
                    unset($results[$i]);
                }

            }
            else
            {
                unset($results[$i]);
            }
        }

        return $results;
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
        $path = "{$mediaItem->id}/{$mediaItem->getSlug()}.{$file->getClientOriginalExtension()}";
        Storage::disk('media')->put(
            $path,
            $fileHandle
        );

        fclose($fileHandle);

        if ($isImage)
        {
            $mediaItem->optimize(true);

            Media::createThumb($mediaItem, $file);
        }

        return response()->json(["messages" => "successfully updated ".$name], Response::HTTP_OK);
    }
}
