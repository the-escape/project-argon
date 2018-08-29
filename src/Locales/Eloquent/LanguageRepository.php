<?php

namespace Escape\Argon\Locales\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;

class LanguageRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Language::class;
    }

    /**
     * @param string $languageCode
     * @return Language
     */
    public function getByLanguageCode($languageCode)
    {
        return $this->findWhere(['language_code' => $languageCode])->first();
    }
}
