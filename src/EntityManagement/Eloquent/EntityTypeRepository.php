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

}
