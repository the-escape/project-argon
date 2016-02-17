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
            $node = $this->findWhere(['parent' => null])->first();
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
                while ($n->parent != null) {
                    $currentSegment = array_pop($segmentsToCheck);

                    if ($n->slug != $currentSegment) {
                        break;
                    }

                    $n = $nodes[$n->parent];
                }

                if ($n->parent == null) {
                    // Found the leaf.
                    $node = $leaf;
                }
            }

        }

        return $node;
    }
}
