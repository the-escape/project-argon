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
        $localisation = $this->entity->getLocalisation($locale);

        if ($localisation) {
            return $localisation;
        } else {
            return $this->entity->getDefaultLocalisation();
        }
    }

    public function field($fieldName)
    {
        return $this->getCurrentLocalisation()->publishedRevision()->field($fieldName);
    }

    public function combo($fieldName)
    {
        return $this->field($fieldName);
    }

    public function getUrl()
    {
        $segments = [];
        $parent = $this->entity;
        while ($parent->parent) {
            $segments[] = $parent->slug;
            $parent = $parent->parent;
        }

        $segments = array_reverse($segments);

        $url = '/' . implode('/', $segments);

        return $url;
    }
}
