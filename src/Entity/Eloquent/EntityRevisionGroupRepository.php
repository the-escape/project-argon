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
        $entityGroupIds = array_combine($entityGroupIds, $entityGroupIds);

        $entityRevisionGroups = $entityRevision->entityRevisionGroups
            ->keyBy('entity_group_id');

        foreach ($entityRevisionGroups as $entityGroupId => $entityRevisionGroup) {

            if (!in_array($entityGroupId, $entityGroupIds)) {
                $this->delete($entityRevisionGroup->id);
                continue;
            }

            unset($entityGroupIds[$entityGroupId]);
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
