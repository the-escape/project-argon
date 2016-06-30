<?php

namespace Escape\Argon\Frontend;

use Escape\Argon\Core\Http\Request;
use Escape\Argon\EntityManagement\Eloquent\Entity;
use Escape\Argon\EntityManagement\Eloquent\EntityRepository;

class Page
{
    /** @var Entity */
    protected $entity;

    /** @var Request */
    protected $request;

    public function __construct(Entity $entity, Request $request=null)
    {
        $this->entity = $entity;
        $this->request = isset($request) ? $request : app()->make('\Escape\Argon\Core\Http\Request');
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

    public function getLocalisations()
    {
        return $this->entity->getLocalisations();
    }


    public function fields()
    {
        return $this->entity->type->fields;
    }

    public function fieldExists($field_slug)
    {
        $fields = $this->fields();
        foreach ($fields as $field) {
            if ($field_slug == $field->field_slug) {
                return true;
            }
        }
        return false;
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

        $locale = $this->request->getArgonLocale();
        $localisation = $this->entity->getLocalisation($locale);

        // make sure entity has locale revision
        if ($localisation && $locale_slug = $locale->getSlug()) {
            $segments[] = $locale_slug;
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

    public function getId()
    {
        return $this->entity->id;
    }

    public function getBreadcrumbs($formatItems=true, $glue='/')
    {
        $breadcrumbs = [];
        $segments = [];
        $output = [];

        $parent = $this->entity;
        $request_url = $this->request->url();

        while ($parent->parent) {

            if ($formatItems) {

                $page = new self($parent, $this->request);
                $page_url = url($page->getUrl());

                if ($page_url == $request_url) {
                    $formatted = '<li class="breadcrumb current"><span>'.$parent->name.'</span></li>';
                } else {
                    $formatted = '<li class="breadcrumb"><a href="'.$page_url.'">'.$parent->name.'</a></li>';
                }

                $breadcrumbs[] = $formatted;

            } else {

                $segments[] = $parent;

            }

            $parent = $parent->parent;
        }

        if ($formatItems) {
            $page = new self($parent, $this->request);
            $formatted = '<li class="breadcrumb"><a href="'.$page->getUrl().'">'.$parent->name.'</a></li>';
            $breadcrumbs[] = $formatted;
            $breadcrumbs = '<ul class="breadcrumbs">'.implode("<li class='divider'>$glue</li>", array_reverse($breadcrumbs)).'</ul>';
            $output = $breadcrumbs;
        } else {
            $segments[] = $parent;
            $segments = array_reverse($segments);
            $output = $segments;
        }

        return $output;
    }

    public function block($name)
    {
        $entityRepository = app()->make(EntityRepository::class);
        $block = $entityRepository->block($name);
        if ($block === null) {
            throw new \RuntimeException("Undefined block '{$name}'.");
        }
        return $block->toPage($this->request);
    }


    public function getByType(array $typeIds, array $order=[], $paginate=null)
    {
        $entityRepository = app()->make(EntityRepository::class);
        return $entityRepository->findByTypeId($typeIds, $order, $paginate);
    }

    public function getRedirect($localeId=null)
    {
        $redirects = $this->entity->redirect_url;
        if (!$localeId) {
            $locale = $this->request->getArgonLocale();
            $localeId = $locale->getId();
        }
        if (isset($redirects->{$localeId})) {
            return $redirects->{$localeId};
        }
        return null;

    }

    public function getRequest()
    {
        return $this->request;
    }
}
