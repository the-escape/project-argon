<?php

namespace Escape\Argon\Entity\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;

class EntityRevisionGroupRepository extends BaseRepository
{
    public function model()
    {
        return EntityRevisionGroup::class;
    }

    public function createGroups($entityRevisionId, array $entityGroupIds)
    {
        $entityRevisionGroups = [];

        foreach ($entityGroupIds as $order => $entityGroupId) {
            $entityRevisionGroups[] = $this->create([
                'entity_revision_id' => $entityRevisionId,
                'entity_group_id' => $entityGroupId,
                'status' => EntityRevisionGroup::STATUS_UNPUBLISHED,
                'order' => $order,
            ]);
        }

        return $entityRevisionGroups;
    }
}
