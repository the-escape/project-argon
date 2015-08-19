<?php

namespace Escape\Argon\Authentication;

use Prettus\Repository\Eloquent\BaseRepository;

class RoleRepository extends BaseRepository
{
    public function model()
    {
        return Role::class;
    }
}
