<?php

namespace Escape\Argon\Media\Eloquent;

use Illuminate\Database\Eloquent\Model;

class MediaFolder extends Model
{
    protected $childFolders = [];
    protected $fillable = ['name', 'parent'];

    public function setChildFolders(MediaFolder $mediaFolder)
    {
        $this->childFolders[] = $mediaFolder;
    }

    public function getChildFolders()
    {
        return $this->childFolders;
    }

    public function parent()
    {
        return $this->hasOne(MediaFolder::class, 'parent');
    }

    public function children()
    {
        return $this->hasMany(MediaFolder::class, 'parent');
    }

    public function items()
    {
        return $this->hasMany(MediaItem::class, 'folder');
    }

    public function hasChildren()
    {
        return count($this->children) > 0;
    }
}
