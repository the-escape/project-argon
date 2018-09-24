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

    /**
     * @param string $languageCode
     * @return Language
     */
    public function getByRegionId($regionId)
    {
        return $this->findWhere(['id' => $regionId])->first();
    }
}
