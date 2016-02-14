<?php

namespace Escape\Argon\EntityManagement\Eloquent\Collections;

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
