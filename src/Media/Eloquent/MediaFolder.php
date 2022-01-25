<?php

namespace Escape\Argon\Media\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MediaFolder extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'parent'];

    public function parent()
    {
        return $this->hasOne(MediaFolder::class, 'parent');
    }

    public function children()
    {
        return $this->hasMany(MediaFolder::class, 'parent');
    }

    public function hasItems()
    {
        return $this->items->count() > 0;
    }

    public function hasChildren()
    {
        return count($this->children) > 0;
    }

    public function items()
    {
        return $this->hasMany(MediaItem::class, 'folder');
    }

    public function getId()
    {
        return $this->id;
    }

    public function getParentId()
    {
        return $this->parent;
    }

    public function getName()
    {
        return $this->name;
    }
}
