<?php

namespace Escape\Argon\Media\Transformers;

use Escape\Argon\Media\Eloquent\MediaFolder;
use League\Fractal\TransformerAbstract;

class MediaFolderTransformer extends TransformerAbstract
{
    public function transform(MediaFolder $mediaFolder)
    {
        $numberOfChildren = $mediaFolder->children->count() + $mediaFolder->items->count();

        return [
            'id' => (int) $mediaFolder->id,
            'name' => $mediaFolder->name,
            'parent' => (int) $mediaFolder->parent,
            'numberOfChildren' => $numberOfChildren,
        ];
    }
}
