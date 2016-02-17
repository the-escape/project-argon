<?php

namespace Escape\Argon\Frontend;

use Escape\Argon\EntityManagement\Eloquent\Entity;

class Page
{
    /** @var Entity */
    protected $entity;

    public function construct(Entity $entity)
    {
        $this->entity = $entity;
    }

    public function get($fieldName)
    {
    }
}
