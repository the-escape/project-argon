<?php

namespace Escape\Argon\Media\Eloquent;

use Illuminate\Database\Eloquent\Model;

class MediaFolder extends Model
{
    protected $fillable = ['name', 'parent'];

    public function parent()
    {
        return $this->hasOne(MediaFolder::class, 'parent');
    }

    public function children()
    {
        return $this->hasMany(MediaFolder::class, 'parent');
    }

    public function hasChildren()
    {
        return count($this->children) > 0;
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
