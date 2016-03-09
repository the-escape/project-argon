<?php

namespace Escape\Argon\EntityManagement\Eloquent;

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
     * @param string $path
     * @return Entity|null
     */
    public function findForPath($path)
    {
        $node = null;

        if ($path == '/') {
            $node = $this->findWhere(['parent_id' => null])->first();
        } else {
            $segments = explode('/', $path);

            array_unshift($segments, '/');

            /** @var Collection $nodes */
            $nodes = $this->findWhereIn('slug', $segments)->keyBy('id');

            $leafs = $nodes->filter(function ($n) use ($segments) {
               return $n->slug == last($segments);
            });

            $segmentsToCheck = $segments;

            foreach ($leafs as $leaf) {
                $n = $leaf;
                while ($n->parent_id != null) {
                    $currentSegment = array_pop($segmentsToCheck);

                    if ($n->slug != $currentSegment) {
                        break;
                    }

                    $n = $nodes[$n->parent_id];
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
     * Returns entities specified by type(s).
     * @param array $typeIds - array of entity_type_id
     * @param array $order - array of column names from entities table
     * @param int $paginate - number of items per page
     * @return mixed Collection|LengthAwarePaginator - depending on paginate parameter
     */
    public function findByType(array $typeIds, array $order=[], $paginate=null)
    {
        $r = $this->model->whereIn('entity_type_id', $typeIds);

        foreach ($order as $o) {
            $r->orderBy($o);
        }

        return ($paginate)
            ? $r->paginate($paginate)
            : $r->get();
    }
}
