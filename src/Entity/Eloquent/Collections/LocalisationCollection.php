<?php

namespace Escape\Argon\Entity\Eloquent\Collections;

use Illuminate\Database\Eloquent\Collection;

class LocalisationCollection extends Collection
{
    public function getLocales()
    {
        return new Collection($this->map(function ($l) {
            return $l->getLocale();
        }));
    }
}
