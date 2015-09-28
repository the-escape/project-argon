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

    public function custom()
    {
        return $this->findWhere(['system' => 0]);
    }

    public function system()
    {
        return $this->findWhere(['system' => 1]);
    }

    public function getByEntityType($type)
    {
        $groups = $this->model
            ->distinct()
            ->select('entity_groups.id', 'entity_groups.name', 'entity_groups.order', 'entity_groups.settings')
            ->join('entity_fields', 'entity_fields.group_id', '=', 'entity_groups.id')
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
