<?php

namespace Escape\Argon\Media\Eloquent;

use Illuminate\Database\Eloquent\Model;

class MediaItem extends Model
{
    protected $fillable = ['filename', 'filesize', 'extension', 'folder', 'mimetype', 'meta', 'uploaded_by'];
}
