<?php

namespace Escape\Argon\EntityManagement\Transformers;

use Escape\Argon\EntityManagement\Eloquent\EntityRevisionGroup;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;

class EntityRevisionGroupTransformer extends TransformerAbstract
{
    public $availableIncludes = [
        'entityGroup',
    ];

    public function transform(EntityRevisionGroup $entityRevisionGroup)
    {
        return [
            'id' => (int) $entityRevisionGroup->id,
            'name' => $entityRevisionGroup->entityGroup->name,
            'entity_group_id' => (int) $entityRevisionGroup->entity_group_id,
        ];
    }

    public function includeEntityGroup(EntityRevisionGroup $entityRevisionGroup)
    {
        return new Item($entityRevisionGroup->entityGroup, new EntityGroupTransformer());
    }
}
