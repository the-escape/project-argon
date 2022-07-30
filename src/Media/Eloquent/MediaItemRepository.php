<?php

namespace Escape\Argon\Media\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;

class MediaItemRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MediaItem::class;
    }

    public function getItemsInFolder($folderId)
    {
        return $this->findWhere(['folder' => $folderId]);
    }

    public function itemExists($name, $folderId)
    {
        $count = $this->findWhere(['folder' => $folderId, 'filename' => $name])->count();
        return $count > 0;
    }

    public function delete($id)
    {
        $deleted = parent::delete($id);

        if ($deleted) {
            $path = 'media/' . $id;

            if ($exists = \File::exists($path)) {
                \File::deleteDirectory($path);
            }
        }

        return $deleted;
    }
}
