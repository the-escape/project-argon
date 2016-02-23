<?php

namespace Escape\Argon\Media\Eloquent;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Escape\Argon\Media\Helpers\Media as MediaHelpers;

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
 * @property \stdClass meta
 * @property boolean hasThumb
 */
class MediaItem extends Model implements Arrayable
{
    use SoftDeletes;

    protected $fillable = [
        'filename',
        'filesize',
        'extension',
        'folder',
        'mimetype',
        'meta',
        'uploaded_by',
        'hasThumb'
    ];

    public function toArray()
    {
        $item = parent::toArray();
        if ($this->hasThumb) {
            $item['thumbUrl'] = "/media/{$this->id}/{$this->id}.thumb.{$this->extension}";
        } else {
            $item['thumbUrl'] = 'http://placehold.it/100x100';
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
        return "{$folder_path}/{$this->id}/{$this->id}.original.{$this->extension}";
    }

    public function getUrl()
    {
        return "/media/{$this->id}/{$this->id}.original.{$this->extension}";
    }

    public function getDimentions()
    {
        $dimentions = new \stdClass();

        if (@$this->meta->width && @$this->meta->height) {
            $dimentions->width = $this->meta->width;
            $dimentions->height = $this->meta->height;
        } else {
            list($width, $height) = @getimagesize($this->getPath());
            $dimentions->width = @$width;
            $dimentions->height = @$height;
        }

        return $dimentions;
    }

    public function getWidth($px='')
    {
        return $this->getDimentions()->width.$px;
    }

    public function getHeight($px='')
    {
        return $this->getDimentions()->height.$px;
    }

    public function getAlt($default='')
    {
        return isset($this->data->alt) ? $this->data->alt : $default;
    }

    public function getFriendlyFilesize()
    {
        return isset($this->filesize_formatted)
            ? $this->filesize_formatted
            : MediaHelpers::size_format($this->filesize);
    }

    public function getFullName()
    {
        return $this->filename.'.'.$this->extension;
    }


}
