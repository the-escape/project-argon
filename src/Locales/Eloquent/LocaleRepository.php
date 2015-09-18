<?php

namespace Escape\Argon\Locales\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;

class LocaleRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Locale::class;
    }

    public function primary()
    {
        $this->resetModel();

        $first = $this->model->query()->first();

        return $first;
    }
}
