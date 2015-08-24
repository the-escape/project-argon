<?php

namespace Escape\Argon\EntityManagement\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;

class FieldDataRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return FieldData::class;
    }
}
