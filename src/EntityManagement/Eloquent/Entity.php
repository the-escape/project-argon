<?php

namespace Escape\Argon\EntityManagement\Eloquent;

use Escape\Argon\EntityManagement\FieldTypes\FieldTypesManager;
use Escape\Argon\EntityManagement\RevisionStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entity extends Model
{
    protected $children = [];

    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'parent', 'entity_type_id', 'owner_id', 'locale'];

    public function addChild(Entity $child)
    {
        //TODO add support for ordering.
        $this->children[] = $child;
    }

    public function hasChildren()
    {
        return !empty($this->children);
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function field($name)
    {
        return $this->latest()->field($name);
    }

    public function type()
    {
        return $this->belongsTo(EntityType::class, 'entity_type_id');
    }

    public function revisions()
    {
        return $this->hasMany(EntityRevision::class);
    }

    public function getLatestAttribute($value)
    {
        return $this->latest();
    }

    /**
     * @return EntityRevision
     */
    public function latest()
    {
        return $this->revisions()->orderBy('created_at', 'desc')->first();
    }

    public function latestPublished()
    {
        return $this->revisions()->where('status', RevisionStatus::PUBLISHED)->orderBy('created_at', 'desc')->first();
    }
}
