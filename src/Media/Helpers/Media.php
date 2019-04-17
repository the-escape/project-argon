<?php

namespace Escape\Argon\Media\Helpers;

use Escape\Argon\Media\Eloquent\MediaFolder;
use Escape\Argon\Media\Eloquent\MediaFolderRepository;
use Escape\Argon\Media\Eloquent\MediaItemRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Escape\Argon\Authentication\User;
use Image;
use stdClass;

class Media
{

    /**
     * Convert number of bytes largest unit bytes will fit into.
     *
     * It is easier to read 1kB than 1024 bytes and 1MB than 1048576 bytes. Converts
     * number of bytes to human readable number by taking the number of that unit
     * that the bytes will go into it. Supports TB value.
     *
     * Please note that integers in PHP are limited to 32 bits, unless they are on
     * 64 bit architecture, then they have 64 bit size. If you need to place the
     * larger size then what PHP integer type will hold, then use a string. It will
     * be converted to a double, which should always have 64 bit length.
     *
     * Technically the correct unit names for powers of 1024 are KiB, MiB etc.
     *
     * @param int|string $bytes    Number of bytes. Note max integer size for integers.
     * @param int        $decimals Optional. Precision of number of decimal places. Default 0.
     * @return bool|string False on failure. Number string on success.
     */
    public static function sizeFormat($bytes, $decimals = 0)
    {
        $quant = [
            // ========================= Origin ====
            'TB' => 1099511627776,  // pow( 1024, 4)
            'GB' => 1073741824,     // pow( 1024, 3)
            'MB' => 1048576,        // pow( 1024, 2)
            'kB' => 1024,           // pow( 1024, 1)
            'B ' => 1,              // pow( 1024, 0)
        ];

        foreach ($quant as $unit => $mag)
        {
            if (doubleval($bytes) >= $mag)
            {
                return number_format(($bytes / $mag), abs(intval($decimals))) . ' ' . $unit;
            }
        }

        return false;
    }


    public static function isImage($mimeType, array $imageMimeTypes=[])
    {
        $defaultImageMimeTypes = [
            "image/jpg",
            "image/jpeg",
            "image/png",
            "image/gif",
        ];

        $mimeTypes = array_merge($defaultImageMimeTypes, $imageMimeTypes);

        return in_array($mimeType, $mimeTypes);
    }


    public static function isPdf($mimeType, array $imageMimeTypes=[])
    {
        $defaultImageMimeTypes = [
            "application/pdf"
        ];

        $mimeTypes = array_merge($defaultImageMimeTypes, $imageMimeTypes);

        return in_array($mimeType, $mimeTypes);
    }


    /**
     * @param $file
     * @param int $folderId
     * @param int $userId
     * @param MediaItemRepository|null $mediaRepository
     * @param string $storageDisk
     * @return mixed
     */
    public static function saveUploadedFile($file, $folderId, $userId, MediaItemRepository $mediaRepository=null, $storageDisk='media', $optimize = true)
    {
        if ($mediaRepository === null)
        {
            $mediaRepository = app()->make(MediaItemRepository::class);
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

        $tmpPath = $file->getRealPath();

        $meta = new stdClass();

        if ($isImage)
        {
            list($meta->width, $meta->height) = @getimagesize($tmpPath);
        }

        $mediaItem = $mediaRepository->create([
            'folder' => $folderId,
            'filename' => $name,
            'slug' => str_slug($name),
            'extension' => $file->getClientOriginalExtension(),
            'filesize' => $file->getSize(),
            'mimetype' => $file->getMimeType(),
            'meta' => json_encode($meta),
            'uploaded_by' => $userId,
        ]);

        $disk = Storage::disk($storageDisk);
        $disk->makeDirectory($mediaItem->id);
        $fileHandle = fopen($tmpPath, 'r+');
        Storage::disk($storageDisk)->put(
            "{$mediaItem->id}/{$mediaItem->getSlug()}.{$file->getClientOriginalExtension()}",
            $fileHandle
        );
        fclose($fileHandle);

        // create humbnail + optimize original
        if ($isImage)
        {
            if ($optimize)
            {
                $mediaItem->optimize();
            }

            Media::createThumb($mediaItem, $file, $storageDisk);
        }

        return $mediaItem;
    }

    public static function createThumb($mediaItem, $file, $storageDisk = 'media')
    {
        $tmpPath = $file->getRealPath();
        list($width, $height) = @getimagesize($tmpPath);

        if($width > $height) {
            $ratioChange = 100 / $width;
            $newWidth = 100;
            $newHeight = $height * $ratioChange;
        } else {
            $ratioChange = 100 / $height;
            $newHeight = 100;
            $newWidth = $width * $ratioChange;
        }

        $newWidth = ceil($newWidth);
        $newHeight = ceil($newHeight);

        $thumb = Image::make($file);
        $thumb = $thumb->fit($newWidth, $newHeight);
        Storage::disk($storageDisk)->put(
            "{$mediaItem->id}/{$mediaItem->getSlug()}.thumb.{$file->getClientOriginalExtension()}",
            $thumb->encode()
        );

        $mediaItem->hasThumb = true;
        $mediaItem->save();
    }

    public static function getFolderTree(MediaFolder $folder = null, $level=0, array $tree=[])
    {
        if ($folder === null)
        {
            $folderRepository = app()->make(MediaFolderRepository::class);
            $folder = $folderRepository->root();
        }

        $folderId = $folder->getId();

        $tree[$folderId] = [
            'id' => $folderId,
            'name' => $folder->getName(),
            'level' => $level,
            'children' => [],
        ];

        $children = $folder->children;

        if ($children)
        {
            $level++;

            foreach($children as $child)
            {
                $tree[$folderId]['children'] = self::getFolderTree($child, $level, $tree[$folderId]['children']);
            }
        }

        return $tree;
    }



    public static function traverseFolders(array $folders=[], callable $callback, array $r=[])
    {
        foreach ($folders as $folder)
        {
            $r[] = $callback($folder);

            if ($folder['children'])
            {
                $r = Media::traverseFolders($folder['children'], $callback, $r);
            }
        }

        return $r;
    }


    public static function tree($items, $parent=null)
    {
        $tree = [];

        foreach ($items as $item)
        {
            if ($parent == $item->parent)
            {
                $item->children = Media::tree($items, $item->id);
                $tree[] = $item;
            }
        }

        return $tree;
    }

    public static function treeLevel($items, $parent=null, $level=null)
    {
        $tree = [];

        foreach ($items as $item)
        {
            if ($parent == $item->parent)
            {
                if ($level)
                {
                    $item->children = Media::treeLevel($items, $item->id, $level-1);
                    $tree[] = $item;
                }
            }
        }

        return $tree;
    }

    public static function addItems($folder, $media_items)
    {
        foreach ($media_items as $media_item)
        {
            if ($media_item->folder == $folder->id)
            {
                $media_item->filesize_formatted = self::sizeFormat($media_item->filesize);
                $author = User::withTrashed()->where('id', $media_item->uploaded_by)->first();

                $media_item->authorName = '';
                $media_item->authorImage = '';

                if($author){
                    $media_item->authorName = $author->name;
                    $media_item->authorImage = $author->profile('image','/argon/images/user-icon.png');
                }
                $folder->items[] = $media_item;
            }
        }

        foreach ($folder->children as $i => &$child)
        {
            $child = Media::addItems($child, $media_items);
        }

        return $folder;
    }
}


