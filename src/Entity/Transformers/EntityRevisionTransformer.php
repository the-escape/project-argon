<?php

namespace Escape\Argon\Entity\Transformers;

use Escape\Argon\Entity\Eloquent\EntityRevision;
use League\Fractal\Resource\Collection;
use League\Fractal\TransformerAbstract;

class EntityRevisionTransformer extends TransformerAbstract
{
    public $availableIncludes = [
        'entityGroups',
        'entityRevisionGroups',
    ];

    public function transform(EntityRevision $entityRevision)
    {
        return [
            'id' => (int) $entityRevision->id,
        ];
    }

    public function includeEntityGroups(EntityRevision $entityRevision)
    {
        $entityRevisionGroups = $entityRevision->entityRevisionGroups->pluck('entity_group_id')->toArray();

        $entityGroups = $entityRevision->localisation->entity->type->groups->filter(function ($group) use ($entityRevisionGroups) {
            return !in_array($group->id, $entityRevisionGroups);
        });

        return new Collection($entityGroups, new EntityGroupTransformer());
    }

    public function includeEntityRevisionGroups(EntityRevision $entityRevision)
    {
        return new Collection($entityRevision->entityRevisionGroups, new EntityRevisionGroupTransformer());
    }
}
