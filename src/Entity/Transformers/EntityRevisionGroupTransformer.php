<?php

namespace Escape\Argon\Entity\Transformers;

use Escape\Argon\Entity\Eloquent\EntityRevisionGroup;
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
