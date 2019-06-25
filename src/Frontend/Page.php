<?php

namespace Escape\Argon\Frontend;

use Escape\Argon\Core\Http\Request;
use Escape\Argon\EntityManagement\Contracts\Compressable;
use Escape\Argon\EntityManagement\Eloquent\Entity;
use Escape\Argon\EntityManagement\Eloquent\EntityRepository;
use Escape\Argon\EntityManagement\Eloquent\Localisation;
use Illuminate\Support\Collection;
use RuntimeException;

class Page implements Compressable
{
    /** @var Entity */
    protected $entity;

    /** @var Request */
    protected $request;

    protected $revisionId;

    public function __construct(Entity $entity, Request $request=null)
    {
        $this->entity = $entity;

        if (!$request instanceof \Escape\Argon\Core\Http\Request)
        {
            $request = new \Escape\Argon\Core\Http\Request;
            $request->adjustLocale();
        }

        $this->request  = $request;

        $this->revisionId = $this->isPreview();
    }

    public function adjustLocale(Localisation $localisation)
    {
        $this->request->adjustLocale($localisation);
    }

    public function isPreview()
    {
        // TODO: Check for admin role.
        return !auth()->guest() && $this->request->has('preview_page')
            ? $this->request->get('preview_page')
            : null;
    }

    public function getCurrentLocalisation()
    {
        $locale = $this->getLocale();
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
        $revision = null;

        $url = $this->getUrl();

        if ($url !== '/') {
            $url = trim($url, '/');
        }

        $requestPath = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

        if ($this->entity->type->type === 'page' && str_is($requestPath, $url)) {
            $revision = $this->revisionId;
        }

        return $this->getCurrentLocalisation()->publishedRevision($revision)->field($fieldName);
    }

    public function combo($fieldName)
    {
        return $this->field($fieldName);
    }

    public function getUrl($locale = null)
    {
        if (isset($this->url))
        {
            return $this->url;
        }
        $segments = [];
        $parent = $this->entity;
        if($parent->parent) {
            $segments[] = $parent->slug;

            while ($parent->parent) {
                $parent = $parent->parent;
                if(!is_null($parent->slug))
                {
                    $segments[] = $parent->slug;
                }
            }
        }
        else
        {
            if($this->entity->slug !== '/')#
            {
                $segments[] = $this->entity->slug;
            }
        }

        $locale = $locale ? $locale : $this->getLocale();
        $localisation = $this->entity->getLocalisation($locale);

        // make sure entity has locale revision
        if ($localisation && $locale_slug = $locale->getSlug()) {
            $segments[] = $locale_slug;
        }

        $segments = array_reverse($segments);

        $url = '/' . implode('/', $segments);


        $this->url = $url;
        return $url;
    }

    public function getHomeUrl($locale = null)
    {
        $segments = [];

        $locale = $locale ? $locale : $this->getLocale();
        $localisation = $this->entity->getLocalisation($locale);

        // make sure entity has locale revision
        if ($localisation && $locale_slug = $locale->getSlug()) {
            $segments[] = $locale_slug;
        }

        $url = '/' . implode('/', $segments);

        return $url;
    }

    public function getUrlWithQueryString(array $set=[], array $unset=[])
    {
        return getUrlWithQueryString($set, $unset, $this->getUrl());
    }

//    public function getEntity()
//    {
//        return $this->entity;
//    }

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

    public function getParentId()
    {
        return $this->entity->parent_id;
    }

    public function getTypeId()
    {
        return $this->entity->entity_type_id;
    }

    public function getLocale()
    {
        return $this->request->getArgonLocale();
    }

    public function getBreadcrumbs($formatItems=true, $glue='/', callable $callback=null)
    {
        $breadcrumbs = [];
        $segments = [];
        $output = [];

        $request_url = $this->request->url();

        $parent = $this->entity;
        if ($callback)
        {
            $parent = call_user_func_array($callback, [$parent, $this->request]);
        }

        while ($parent->parent) {

            if ($callback)
            {
                $parent->parent = call_user_func_array($callback, [$parent->parent, $this->request]);
            }

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


    public function findByTypeId(array $typeIds, array $order=[], $paginate=null)
    {
        $entityRepository = app()->make(EntityRepository::class);
        return $entityRepository->findByTypeId($typeIds, $order, $paginate);
    }

    public function getRedirect($localeId=null)
    {
        $redirects = $this->entity->redirect_url;
        if (!$localeId) {
            $localeId = $this->getLocale()->getId();
        }
        if (isset($redirects->{$localeId})) {
            return $redirects->{$localeId};
        }
        return null;

    }

    public function getGroupOrder($localeId=null)
    {
        if (!$localeId) {
            $localeId = $this->getLocale()->getId();
        }
        return $this->entity->getGroupOrder($localeId);
    }

    public function getRenderableGroupOrder($localeId=null)
    {
        if (!$localeId) {
            $localeId = $this->getLocale()->getId();
        }
        return $this->entity->getRenderableGroupOrder($localeId);
    }

    public function isGroupRender($groupId, $localeId=null)
    {
        if (!$localeId) {
            $localeId = $this->getLocale()->getId();
        }
        return $this->entity->isGroupRender($localeId, $groupId);
    }

    public function getRenderedGroups()
    {
        $renderableGroups = $this->getRenderableGroupOrder();

        $r = new Collection();
        foreach ($renderableGroups as $renderableGroup) {
            if ($this->isGroupRender($renderableGroup)) {
                $r->push($renderableGroup);
            }
        }
        return $r;
    }


    public function findWhere(array $where , $columns = array('*'))
    {
        $entityRepository = app()->make(EntityRepository::class);
        $results = $entityRepository->findWhere($where, $columns);
        $r = new Collection();
        foreach ($results as $result) {
            $r->push($result->toPage($this->request));
        }
        return $r;
    }

    public function getRequest()
    {
        return $this->request;
    }

    public function compress()
    {
        $values = [];

        $fields = $this->fields();

        foreach ($fields as $field)
        {
            $fieldValue = $this->field($field->field_slug);
            $values[$field->field_slug] = $fieldValue->compress();
        }

        return $values;
    }
}
