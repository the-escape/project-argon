<?php

namespace Escape\Argon\Entity\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EntityRevisionGroup extends Model
{
    const STATUS_UNPUBLISHED = 0;
    const STATUS_PUBLISHED = 1;

    use SoftDeletes;

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
}
