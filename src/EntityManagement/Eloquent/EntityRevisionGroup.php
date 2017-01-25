<?php

namespace Escape\Argon\EntityManagement\Eloquent;

use Illuminate\Database\Eloquent\Model;

class EntityRevisionGroup extends Model
{
    const STATUS_UNPUBLISHED = 0;
    const STATUS_PUBLISHED = 1;

    protected $fillable = [
        'entity_revision_id',
        'entity_group_id',
        'status',
        'order',
    ];

    public function entityGroup()
    {
        return $this->hasOne(EntityGroup::class, 'id', 'entity_group_id');
    }

    public function entityFields()
    {
        return $this->hasManyThrough(EntityField::class, EntityGroup::class, 'id', 'entity_group_id', 'entity_group_id');
    }
}
