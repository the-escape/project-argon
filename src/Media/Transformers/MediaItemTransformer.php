<?php

namespace Escape\Argon\Media\Transformers;

use Escape\Argon\Media\Eloquent\MediaItem;
use League\Fractal\TransformerAbstract;

class MediaItemTransformer extends TransformerAbstract
{
    public function transform(MediaItem $mediaItem)
    {
        $uploadedBy = $mediaItem->uploadedBy->count() > 0 ? $mediaItem->uploadedBy->name : '-';

        return [
            'id' => (int) $mediaItem->id,
            'filename' => $mediaItem->filename,
            'extension' => $mediaItem->extension,
            'filesize' => $mediaItem->getFriendlyFilesize(),
            'width' => $mediaItem->getWidth(),
            'height' => $mediaItem->getHeight(),
            'folder' => (int) $mediaItem->folder,
            'url' => $mediaItem->getUrl(),
            'thumbUrl' => $mediaItem->getThumbUrl(),
            'uploadedBy' => $uploadedBy,
            'uploadedAt' => $mediaItem->created_at->format('dS F Y'),
        ];
    }
}
