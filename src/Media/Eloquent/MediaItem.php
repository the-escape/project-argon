<?php

namespace Escape\Argon\Media\Eloquent;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    protected $fillable = ['filename', 'filesize', 'extension', 'folder', 'mimetype', 'meta', 'uploaded_by', 'hasThumb'];

    public function toArray()
    {
	$item = parent::toArray();
	if ($this->hasThumb) {
	    $item['thumbUrl'] = "/media/{$this->id}/{$this->id}.thumb.{$this->extension}";
	} else {
	    $item['thumbUrl'] = 'http://placehold.it/100x100';
	}

	$item['url'] = "/media/{$this->id}/{$this->id}.original.{$this->extension}";

	return $item;
    }
}
