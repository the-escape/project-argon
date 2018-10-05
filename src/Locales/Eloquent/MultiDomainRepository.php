<?php

namespace Escape\Argon\Locales\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;

class MultiDomainRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MultiDomain::class;
    }

    /**
     * @param string $domain
     * @return Language
     */
    public function getByDomain($domain)
    {
        return $this->findWhere(['domain_url' => $domain])->first();
    }
}
