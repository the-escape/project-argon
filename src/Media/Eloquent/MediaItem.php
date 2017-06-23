<?php

namespace Escape\Argon\Media\Eloquent;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Escape\Argon\Media\Helpers\Media as MediaHelpers;
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
 */
class MediaItem extends Model implements Arrayable
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
        'hasThumb'
    ];

    public function mediaFolder()
    {
        return $this->hasOne(MediaFolder::class,'id', 'folder');
    }

    public function toArray()
    {
        $item = parent::toArray();
        if ($this->hasThumb) {
            $item['thumbUrl'] = "/media/{$this->id}/{$this->getSlug()}.thumb.{$this->extension}";
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

    public function getUrl()
    {
        return "/media/{$this->id}/{$this->getSlug()}.{$this->extension}";
    }

    public function getDimensions()
    {
        $dimensions = new stdClass();

        if (@$this->meta->width && @$this->meta->height) {
            $dimensions->width = $this->meta->width;
            $dimensions->height = $this->meta->height;
        } else {
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
        return isset($this->data->alt) ? $this->data->alt : $default;
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
        return empty($this->slug) ? $this->id : $this->slug;
    }
}
