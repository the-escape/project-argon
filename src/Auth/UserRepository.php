<?php

namespace Escape\Argon\Auth;

use Prettus\Repository\Eloquent\BaseRepository;

class UserRepository extends BaseRepository
{
    public function model()
    {
        return User::class;
    }
}
