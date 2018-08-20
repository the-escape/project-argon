<?php

namespace Escape\Argon\EntityManagement\Helpers;

use Escape\Argon\EntityManagement\Eloquent\EntityRepository;

class Pages
{
    public static function sitetree()
    {
        $entityRepository = app()->make(EntityRepository::class);

        $entities = $entityRepository->pages()->keyBy('id');

        foreach ($entities as $id => $entity)
        {
            if ($entity->parent_id)
            {
                $entities[$entity->parent_id]->addChild($entity);
            }
        }

        return $entities->filter(function ($entity) {
            return $entity->parent_id == null;
        });
    }
}
