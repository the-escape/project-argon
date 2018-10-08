<?php

namespace Escape\Argon\Locales\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;

class RegionRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Region::class;
    }

    public function getActive()
    {
        return $this->findWhere(['active' => true])->andWhere('deleted_at', 'not', null)->get();
    }

    /**
     * @param string $languageCode
     * @return Language
     */
    public function getByRegionId($regionId)
    {
        return $this->findWhere(['id' => $regionId])->first();
    }
}
