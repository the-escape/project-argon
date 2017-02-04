<?php

namespace Escape\Argon\Entity\Transformers;

use Escape\Argon\Entity\Eloquent\EntityGroup;
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
