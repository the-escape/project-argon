<?php

namespace Escape\Argon\Menus\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;

class MenuRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Menu::class;
    }

    /**
     * @param string $slug
     * @return Menu
     */
    public function getBySlug($slug)
    {
        return $this->findWhere(['slug' => $slug])->first();
    }
}
