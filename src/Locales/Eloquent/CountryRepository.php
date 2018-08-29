<?php

namespace Escape\Argon\Locales\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;

class CountryRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Country::class;
    }

    /**
     * @param string $isoCode
     * @return Country
     */
    public function getByIsoCode($isoCode)
    {
        return $this->findWhere(['iso_code' => $isoCode])->first();
    }
}
