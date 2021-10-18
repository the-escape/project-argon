<?php

namespace Escape\Argon\Locales\Controllers;

use Escape\Argon\Core\Controllers\BaseController;
use Escape\Argon\Locales\Eloquent\CountryRepository;
use Escape\Argon\Locales\Eloquent\LanguageRepository;
use Escape\Argon\Locales\Eloquent\LocaleRepository;
use Escape\Argon\Locales\Eloquent\RegionRepository;
use Illuminate\Http\Request;
use Lang;
use Redirect;
use View;

class LocalesController extends BaseController
{
    /**
     * LocalesController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->middleware('perm:cms:login');
        $this->middleware('perm:cms:locale:manage');

        parent::__construct($request);
    }

    /**
     * @param LocaleRepository $localeRepository
     * @return mixed
     */
    public function manage(LocaleRepository $localeRepository)
    {
        $locales = $localeRepository->with(
            ['language', 'country', 'region']
        )->all();

        return View::make('argon::locales.manage', ['locales' => $locales]);
    }

    /**
     * @return mixed
     */
    public function create(CountryRepository $countryRepository, LanguageRepository $languageRepository, RegionRepository $regionRepository)
    {
        $countries = $countryRepository->all();
        $languages = $languageRepository->all();
        $regions = $regionRepository->all();

        return View::make('argon::locales.create', ['countries' => $countries, 'languages' => $languages, 'regions' => $regions]);
    }

    /**
     * @param LocaleRepository $localesRepository
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function save(LocaleRepository $localesRepository)
    {
        $locale = $localesRepository->create(
            $this->request->all()
        );

        return Redirect::route('cms:locales:manage');
    }

    /**
     * @param $localeId
     * @param LocaleRepository $localesRepository
     * @return mixed
     */
    public function delete($localeId, LocaleRepository $localesRepository)
    {
        $localesRepository->delete($localeId);

        return Redirect::route('cms:locales:manage');
    }

    /**
     * @param $localeId
     * @param LocaleRepository $localesRepository
     * @return mixed
     */
    public function edit($localeId, LocaleRepository $localesRepository, CountryRepository $countryRepository, LanguageRepository $languageRepository, RegionRepository $regionRepository)
    {
        $locale = $localesRepository->find($localeId);
        $countries = $countryRepository->all();
        $languages = $languageRepository->all();
        $regions = $regionRepository->all();

        return View::make('argon::locales.edit', ['locale' => $locale, 'countries' => $countries, 'languages' => $languages, 'regions' => $regions]);
    }

    /**
     * @param $localeId
     * @param LocaleRepository $localesRepository
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update($localeId, LocaleRepository $localesRepository)
    {
        $localesRepository->update($this->request->all(), $localeId);

        return Redirect::route('cms:locales:manage')
            ->with('message', Lang::get('argon-locales::locale.saved'));
    }

    /**
     * @param $localeId
     * @param Request $request
     * @return mixed
     */
    public function set($localeId, Request $request)
    {
        $request->session()->put('locale', $localeId);

        $returnUrl = $request->get('return');

        return Redirect::to($returnUrl);
    }


}
