<?php

namespace Escape\Argon\Redirect\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;

class RedirectRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Redirect::class;
    }

}
