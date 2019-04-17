<?php

namespace Escape\Argon\Media\Eloquent;

use Escape\Argon\Media\Contracts\ImageInterface;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Escape\Argon\Media\Helpers\Media as MediaHelpers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use stdClass;

/**
 * Class MediaItem
 * @package Escape\Argon\Media
 *
 * @property int id
 * @property string filename
 * @property string extension
 * @property int filesize
 * @property int folder
 * @property string mimetype
 * @property stdClass meta
 * @property boolean hasThumb
 * @property boolean optimized
 */
class MediaItem extends Model implements Arrayable, ImageInterface
{
    use SoftDeletes;

    protected $fillable = [
        'slug',
        'filename',
        'filesize',
        'extension',
        'folder',
        'mimetype',
        'meta',
        'uploaded_by',
        'hasThumb',
        'optimized',
    ];

    public function mediaFolder()
    {
        return $this->hasOne(MediaFolder::class,'id', 'folder');
    }

    public function toArray()
    {
        $item = parent::toArray();
        if ($this->hasThumb) {
            $item['thumbUrl'] = $this->getThumb();
        } else {
            $item['thumbUrl'] = '/argon/images/file-info-icon.png';
        }

        $item['url'] = $this->getUrl();

        return $item;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getPath()
    {
        $folder_path = config('filesystems.disks.media.root');
        return "{$folder_path}/{$this->id}/{$this->getSlug()}.{$this->extension}";
    }

    /**
     * Generates URL to asset.
     * Accepts args formatted as query string key=value pairs separated by & symbol.
     * Accpets option string: thumb, original or custom WxH size.
     * @param array $args
     * @param string $option
     * @return string $url
     */
    public function getUrl(array $args=[])
    {
        $properties = [
            'updatedAt' => true,
        ];

        if ($args)
        {
            $properties = array_merge($properties, $args);
        }

        $url = sprintf("/media/%s/%s.%s", $this->id, $this->getSlug(), $this->extension);

        if (!empty($properties['option']))
        {
            $tmpUrl = sprintf("/media/%s/%s.%s.%s", $this->id, $this->getSlug(), $properties['option'], $this->extension);

            if (public_path($tmpUrl))
            {
                $url = $tmpUrl;
            }
        }

        if (in_array($properties['updatedAt'], ['1', 'true', true], true))
        {
            $url = $url."?".strtotime($this->updated_at);
        }

        return $url;
    }

    public function getDimensions()
    {
        $dimensions = new stdClass();

        if (!empty($this->meta->width) && !empty($this->meta->height))
        {
            $dimensions->width = $this->meta->width;
            $dimensions->height = $this->meta->height;
        }
        else
        {
            list($width, $height) = @getimagesize($this->getPath());
            $dimensions->width = @$width;
            $dimensions->height = @$height;
        }

        return $dimensions;
    }

    public function getWidth($px='')
    {
        return $this->getDimensions()->width.$px;
    }

    public function getHeight($px='')
    {
        return $this->getDimensions()->height.$px;
    }

    public function getAlt($default='')
    {
        return (isset($this->data->alt) && $this->data->alt != "") ? $this->data->alt : $default;
    }

    public function getFriendlyFilesize()
    {
        return isset($this->filesize_formatted)
            ? $this->filesize_formatted
            : MediaHelpers::sizeFormat($this->filesize);
    }

    public function getFullName()
    {
        return $this->filename.'.'.$this->extension;
    }

    public function getName()
    {
        return $this->filename;
    }

    public function getExtension()
    {
        return $this->extension;
    }

    public function isImage()
    {
        return MediaHelpers::isImage($this->mimetype);
    }

    public function getParentId()
    {
        return $this->folder;
    }

    public function getSlug()
    {
        return empty($this->slug) ? "{$this->id}.original" : $this->slug;
    }

    /**
     * Generates URL to thumbnail.
     * If argon.medialibrary.fix_thumbs config is set to true it will rename
     * the thumbnail file to contain slug instead of ID.
     * @return string $url
     */
    public function getThumb()
    {
        if($this->hasThumb)
        {
            if(config('argon.medialibrary.fix_thumbs', false))
            {
                $this->fixThumb();
            }

            return $this->getUrl([], 'thumb');
        }
        else
        {
            return $this->getUrl();
        }
    }

    /**
     * Generates URL to original file if optimization is enabled.
     * @return string $url
     */
    public function getUnoptimized()
    {
        if ($this->optimized)
        {
            return $this->getUrl([], 'original');
        }
        else
        {
            return $this->getUrl();
        }
    }

    public function getCustomOption($option = '')
    {
        if (!empty($option))
        {
            return $this->getUrl([
                'option' => $option
            ]);
        }
        else
        {
            return $this->getUrl();
        }
    }

    /**
     * Renames the thumbnail file to contain slug instead of ID.
     * @return boolean
     */
    public function fixThumb()
    {
        $folder_path = config('filesystems.disks.media.root');
        $file = sprintf('/%s/%s.thumb.%s', $this->id, $this->getSlug(), $this->extension);

        if (!file_exists($folder_path.$file))
        {
            $old_file = sprintf('/%s/%s.thumb.%s', $this->id, $this->id, $this->extension);
            if (file_exists($folder_path.$old_file))
            {
                Storage::disk('media')->move($old_file, $file);
                return true;
            }
        }

        return false;
    }

    /**
     * Optimizes the asset using ImageOptim helper.
     * Will create a copy of the original file for further manipulation.
     * @return boolean
     */
    public function optimize($reoptimize = false)
    {
        if ($this->optimized && !$reoptimize)
        {
            return false;
        }

        if (!imageOptim()->isEnabled())
        {
            return false;
        }

        if (!$this->copyOriginal($reoptimize))
        {
            return false;
        }

        $filepath = $this->getPath();


        if (imageOptim()->optimize($filepath))
        {
            $this->update([
                'optimized' => 1
            ]);

            return true;
        }
    }

    /**
     * Creates a copy of the original asset.
     * @return boolean
     */
    private function copyOriginal($reoptimize)
    {
        $folder_path = config('filesystems.disks.media.root');
        $original_file = sprintf('/%s/%s.original.%s', $this->id, $this->getSlug(), $this->extension);

        if (file_exists($folder_path.$original_file) && !$reoptimize)
        {
            return true;
        }

        $file = sprintf('/%s/%s.%s', $this->id, $this->getSlug(), $this->extension);

        if(!file_exists($folder_path.$file))
        {
            return false;
        }

        return File::copy($folder_path.$file, $folder_path.$original_file);
    }

    private function getOriginalPath() {
        $folder_path = config('filesystems.disks.media.root');
        $original_file = sprintf('/%s/%s.original.%s', $this->id, $this->getSlug(), $this->extension);

        if (file_exists($folder_path.$original_file))
        {
            return $folder_path.$original_file;
        }

        return $this->getPath();
    }

    /**
     * refreshes thumbnail
     */
    public function recreateThumbnail()
    {
        $path = $this->getOriginalPath();

        if(!$path || !file_exists($path)){
            return false;
        }

        $file = new UploadedFile($path, $this->getFullName());
        $isImage =  MediaHelpers::isImage($file->getMimeType());
        if($isImage){
            MediaHelpers::createThumb($this, $file);
            return true;
        }

        return false;
    }
}
