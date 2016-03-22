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

    public function __construct(Entity $entity, Request $request=null)
    {
        $this->entity = $entity;
        $this->request = isset($request) ? $request : app()->make(Request::class);
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

    public function getUrlWithQueryString(array $set=[], array $unset=[])
    {
        $url = $this->getUrl();

        $this->request->merge($set);

        $qs = $this->request->all();

        foreach ($unset as $key) {
            unset($qs[$key]);
        }

        if ($qs) {
            $url .= $queryString = '?'.http_build_query($qs);
        }

        return $url;
    }

    public function getName()
    {
        return $this->entity->name;
    }

    public function getSlug()
    {
        return $this->entity->slug;
    }

    public function getBreadcrumbs($glue='/')
    {
        $segments = [];
        $breadcrumbs = [];

        $parent = $this->entity;
        while ($parent->parent) {
            $page = new self($parent, $this->request);
            $formatted = '<a href="'.$page->getUrl().'">'.$parent->name.'</a>';
            $segments[] = [
                'formatted' => $formatted,
                'raw' => $parent,
            ];
            $breadcrumbs[] = $formatted;
            $parent = $parent->parent;
        }

        $page = new self($parent, $this->request);
        $formatted = '<a href="'.$page->getUrl().'">'.$parent->name.'</a>';
        $segments[] = [
            'formatted' => $formatted,
            'raw' => $parent,
        ];
        $breadcrumbs[] = $formatted;

        $segments = array_reverse($segments);
        $breadcrumbs = implode($glue, array_reverse($breadcrumbs));

        return [$breadcrumbs, $segments];
    }

    public function toPage($entity)
    {
        return new self($entity, $this->request);
    }

    public function getByType(array $typeIds, array $order=[], $paginate=null)
    {
        $entityRepository = app()->make(EntityRepository::class);
        return $entityRepository->findByType($typeIds, $order, $paginate);
    }
}
