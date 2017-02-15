<?php

namespace Escape\Argon\Media\Transformers;

use Escape\Argon\Media\Eloquent\MediaItem;
use League\Fractal\TransformerAbstract;

class MediaItemTransformer extends TransformerAbstract
{
    public function transform(MediaItem $mediaItem)
    {
        return [
            'id' => (int) $mediaItem->id,
            'filename' => $mediaItem->filename,
            'folder' => (int) $mediaItem->folder,
        ];
    }
}
