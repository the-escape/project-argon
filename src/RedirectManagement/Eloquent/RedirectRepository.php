<?php

namespace Escape\Argon\RedirectManagement\Eloquent;

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
