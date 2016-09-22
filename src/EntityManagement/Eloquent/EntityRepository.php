<?php

namespace Escape\Argon\EntityManagement\Eloquent;

use Escape\Argon\Core\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Eloquent\BaseRepository;

class EntityRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Entity::class;
    }

    /**
     * @param Request $request
     * @return Entity|null
     */
    public function findForPath($request, $status=1)
    {
        $path = $request->path();

        $preview = $request->has('preview_page');

        $node = null;

        if ($path == '/') {
            $node = $this->makeModel()->whereNull('parent_id');

            if (!$preview) {
                $node = $node->where('status', '=', $status);
            }

            $node = $node->first();
        } else {
            $segments = explode('/', $path);

            array_unshift($segments, '/');

            /** @var Collection $nodes */
            $nodes = $this->model->whereIn('slug', $segments);

            if (!$preview) {
                $nodes = $nodes->where('status','=', $status);
            }

            $nodes = $nodes->with('type')->get();

            foreach ($nodes as $idx => $entity) {
                if ($entity->type->type != 'page'){
                    $nodes->forget($idx);
                }
            }

            $nodes = $nodes->keyBy('id');

            $leafs = $nodes->filter(function ($n) use ($segments) {
                return $n->slug == last($segments);
            });

            $segmentsToCheck = $segments;

            foreach ($leafs as $leaf) {
                $n = $leaf;
                while ($n->parent_id != null) {

                    if (!isset($nodes[$n->parent_id])) {
                        continue 2;
                    }

                    $currentSegment = array_pop($segmentsToCheck);

                    if ($n->slug != $currentSegment) {
                        break;
                    }

                    $matched = $nodes[$n->parent_id];
                    if($matched->slug != end($segmentsToCheck)) {
                        array_push($segmentsToCheck, $currentSegment);
                        continue 2;
                    }
                    $n = $matched;
                }

                if ($n->parent_id == null) {
                    // Found the leaf.
                    $node = $leaf;
                    break;
                }
            }

        }

        return $node;
    }


    /**
     * Returns entities specified by type id(s).
     * @param array $typeIds - array of entity_type_id
     * @param array $order - array of column names from entities table
     * @param int $paginate - number of items per page
     * @return mixed Collection|LengthAwarePaginator - depending on paginate parameter
     */
    public function findByTypeId(array $typeIds, array $order=[], $paginate=null)
    {
        $r = $this->model->whereIn('entity_type_id', $typeIds);

        foreach ($order as $o) {
            $r->orderBy($o);
        }

        return ($paginate)
            ? $r->paginate($paginate)
            : $r->get();
    }


    /**
     * Looks through the entities and filters them based on slug and 'subtype' - (block|page|email)
     * @param $type
     * @param array $slugs
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    protected function type($type, array $slugs=[])
    {
        $entities = $this->model->with('type');

        if ($slugs) {
            $entities = $entities->whereIn('slug', $slugs);
        }

        $entities = $entities->get();

        $entities = $entities->filter(function ($entity) use ($type) {
            if ($entity->type === null) {
                throw new \RuntimeException("Trying to load a {$type} of undefined type for entity id: '{$entity->id}'. Content type was probably soft deleted.");
            }
            return $entity->type->type == $type;
        });

        return $entities;
    }


    public function pages(array $slugs=[])
    {
        return $this->type('page', $slugs);
    }


    public function page($slug)
    {
        return $this->pages([$slug])->first();
    }

    public function getPagesByLocale($localeId)
    {
        $pages = $this->type('page');

        $pages = $pages->filter(function($page) use($localeId) {
            return $page->hasLocalisation($localeId);
        });

        return $pages;
    }


    public function blocks(array $slugs=[])
    {
        return $this->type('block', $slugs);
    }


    public function block($slug)
    {
        return $this->blocks([$slug])->first();
    }


    public function emails(array $slugs=[])
    {
        return $this->type('email', $slugs);
    }


    public function email($slug)
    {
        return $this->emails([$slug])->first();
    }

}
