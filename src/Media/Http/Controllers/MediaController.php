<?php

namespace Escape\Argon\Media\Http\Controllers;

use Escape\Argon\Core\Controllers\BaseController;
use Escape\Argon\Media\Eloquent\MediaFolderRepository;
use Escape\Argon\Media\Eloquent\MediaItemRepository;
use Escape\Argon\Media\Http\Requests\FolderStoreRequest;
use Escape\Argon\Media\Transformers\MediaFolderTransformer;
use Escape\Argon\Media\Transformers\MediaItemTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use Symfony\Component\HttpFoundation\Response;
use View;
use Image;
use Input;

class MediaController extends BaseController
{
    protected $manager;
    protected $mediaFolderRepository;
    protected $mediaItemRepository;
    protected $imageFormats = [
        "image/jpg",
        "image/jpeg",
        "image/png",
        "image/gif"
    ];

    public function setMiddleware()
    {
        return [];
    }

    public function __construct(
        MediaFolderRepository $mediaFolderRepository,
        MediaItemRepository $mediaItemRepository)
    {
        $this->manager = new Manager();
        $this->mediaFolderRepository = $mediaFolderRepository;
        $this->mediaItemRepository = $mediaItemRepository;
        parent::__construct();
    }

    public function index()
    {
        $this->addTabs([]);

        return view('argon.media::pages.index', [
            'name' => 'Media'
        ]);
    }

    public function folders()
    {
        $folders = $this->mediaFolderRepository->all()->keyBy('id');
        /*
        foreach ($folders as $key => $folder) {
            if ($folder->parent) {
                $folders[$folder->parent]->setChildFolders($folder);
            }
        }

        foreach ($folders as $key => $folder) {
            if (!is_null($folder->parent)) {
                unset($folders[$key]);
                continue;
            }
        }
        */
        $collection = new Collection($folders, new MediaFolderTransformer());

        $response = $this->manager->createData($collection)->toArray();

        return response()->json($response);
    }

    public function items($folderId)
    {
        $items = $this->mediaItemRepository
            ->makeModel()
            ->where('folder', '=', $folderId)
            ->orderBy('filename')
            ->get();

        $collection = new Collection($items, new MediaItemTransformer());

        $response = $this->manager->createData($collection)->toArray();

        return response()->json($response);
    }

    public function folderStore(FolderStoreRequest $request)
    {
        $folder = $this->mediaFolderRepository->create([
            'name' => $request->get('name'),
            'parent' => $request->get('parent_id')
        ]);

        $item = new Item($folder, new MediaFolderTransformer());

        $response = $this->manager->createData($item)->toArray();

        return response()->json($response);
    }

    public function rename()
    {

    }

    public function search(Request $request)
    {
        $searchQuery = $request->get('searchQuery');

        $items = [];

        if ($searchQuery) {
            $items = $this->mediaItemRepository
                ->makeModel()
                ->where('filename', 'LIKE', '%' . $searchQuery . '%')
                ->get();
        }

        $collection = new Collection($items, new MediaItemTransformer());

        $response = $this->manager->createData($collection)->toArray();

        return response()->json($response);
    }

    //------------//

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
    /*
    public function items(MediaItemRepository $mediaRepository)
    {
        $folderId = Input::get('folderId');
        $items = $mediaRepository->getItemsInFolder($folderId);

        return response()->json($items);
    }
    */
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

        $isImage =  in_array($file->getClientMimeType(), $this->imageFormats);

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
    /*
    public function createFolder(Request $request, MediaFolderRepository $folderRepository)
    {
        if (!$folderRepository->folderExists($request->input('name'), $request->input('parent'))) {
            $folder = $folderRepository->create($request->input());

            return response()->json($folder);
        } else {
            return response()->json(['error' => 'folder exists'], 409);
        }
    }
    */
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
}
