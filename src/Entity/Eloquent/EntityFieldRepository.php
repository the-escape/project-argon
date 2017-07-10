<?php

namespace Escape\Argon\Entity\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;

class EntityFieldRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return EntityField::class;
    }
}
