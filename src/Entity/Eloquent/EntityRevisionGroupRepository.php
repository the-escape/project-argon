<?php

namespace Escape\Argon\Entity\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;

class EntityRevisionGroupRepository extends BaseRepository
{
    public function model()
    {
        return EntityRevisionGroup::class;
    }

    public function createGroups(EntityRevision $entityRevision, array $entityGroupIds)
    {
        $entityRevisionGroups = $entityRevision->entityRevisionGroups;

        foreach ($entityRevisionGroups as $entityRevisionGroup) {
            $this->delete($entityRevisionGroup->id);
        }

        $entityRevisionGroups = [];

        foreach ($entityGroupIds as $order => $entityGroupId) {
            $entityRevisionGroups[] = $this->create([
                'entity_revision_id' => $entityRevision->id,
                'entity_group_id' => $entityGroupId,
                'status' => EntityRevisionGroup::STATUS_UNPUBLISHED,
                'order' => $order,
            ]);
        }

        return $entityRevisionGroups;
    }
}
