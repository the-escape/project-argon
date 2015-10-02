<?php

namespace Escape\Argon\EntityManagement\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;

class EntityGroupRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return EntityGroup::class;
    }

    /**
     * Get all groups in use for given entity (content) type
     * @param int|string $type - if positive number given, $type be treated as entity_types.id, otherwise $type will be assumed as entity_types.name
     * @return mixed collection result
     */
    public function getUsedGroupsByEntityType($type)
    {
        $groups = $this->model
            ->distinct()
            ->select('entity_groups.*')
            ->join('entity_fields', 'entity_fields.entity_group_id', '=', 'entity_groups.id')
            ->join('entity_types', 'entity_types.id', '=', 'entity_fields.entity_type_id');

        // check if $type is ID
        if (preg_match('/^[1-9][0-9]*$/', $type))
        {
            $groups->where('entity_types.id', $type);
        }
        else
        {
            $groups->where('entity_types.name', $type);
        }

        return $groups->get();
    }
}
