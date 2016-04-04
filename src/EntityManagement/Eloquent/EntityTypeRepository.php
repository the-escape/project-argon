<?php

namespace Escape\Argon\EntityManagement\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;

class EntityTypeRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return EntityType::class;
    }

    public function getTypeByName($typeName)
    {
        return $this->findByField('name', $typeName)->first();
    }

    public function custom()
    {
        return $this->findWhere(['system' => 0]);
    }

    public function page()
    {
        return $this->findWhere(['system' => 0, 'type' => 'page']);
    }

    public function block()
    {
        return $this->findWhere(['system' => 0, 'type' => 'block']);
    }

    public function email()
    {
        return $this->findWhere(['system' => 0, 'type' => 'email']);
    }

    public function system()
    {
        return $this->findWhere(['system' => 1]);
    }

    public function getOrdered()
    {
        return $this->makeModel()->orderBy('name')->get();
    }
}
