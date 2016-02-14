<?php

namespace Escape\Argon\Media\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;

class MediaFolderRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MediaFolder::class;
    }

    public function root()
    {
        return $this->find(1);
    }

    public function folderExists($name, $parent)
    {
        return $this->findWhere(['parent' => $parent, 'name' => $name])->count() > 0;
    }
}
