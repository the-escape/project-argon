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


    public function findByType(array $typeIds)
    {
        return $this->findWhereIn('entity_type_id', $typeIds);
    }
}
