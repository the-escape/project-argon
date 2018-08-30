<?php

namespace Escape\Argon\Locales\Eloquent;

use Prettus\Repository\Eloquent\BaseRepository;

class LocaleRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Locale::class;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model|null|static
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function primary()
    {
        $this->resetModel();

        $first = $this->model->query()->first();

        return $first;
    }

    /**
     * @param string $slug
     * @return Locale
     */
    public function getBySlug($slug)
    {
        return $this->findWhere(['locale_slug' => $slug])->first();
    }

    /**
     * @param string $localeId
     * @return Locale
     */
    public function getFullLocaleById($localeId)
    {
        return $this->findWhere(['id' => $localeId])->with(['language', 'country'])->first();
    }

    /**
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function getDefault()
    {
        return $this->makeModel()->orderBy('created_at')->limit(1)->get()->first();
    }
}
