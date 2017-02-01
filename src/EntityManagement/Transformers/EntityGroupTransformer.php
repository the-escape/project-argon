<?php

namespace Escape\Argon\EntityManagement\Transformers;

use Escape\Argon\EntityManagement\Eloquent\EntityGroup;
use League\Fractal\TransformerAbstract;

class EntityGroupTransformer extends TransformerAbstract
{
    public function transform(EntityGroup $entityGroup)
    {
        return [
            'id' => (int) $entityGroup->id,
            'name' => $entityGroup->name,
        ];
    }
}
