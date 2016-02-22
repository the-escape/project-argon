<?php

namespace Escape\Argon\Frontend;

use Escape\Argon\Core\Http\Request;
use Escape\Argon\EntityManagement\Eloquent\Entity;

class Page
{
    /** @var Entity */
    protected $entity;

    /** @var Request */
    protected $request;

    public function __construct(Entity $entity, Request $request)
    {
        $this->entity = $entity;
        $this->request = $request;
    }

    public function getCurrentLocalisation()
    {
        $locale = $this->request->getArgonLocale();
        return $this->entity->getLocalisation($locale);
    }

    public function field($fieldName)
    {
        return $this->getCurrentLocalisation()->publishedRevision()->field($fieldName);
    }

    public function combo($fieldName)
    {
        return $this->field($fieldName);
    }
}
