<?php

namespace Escape\Argon\Locales\Controllers;

use Escape\Argon\Core\Controllers\BaseController;
use Escape\Argon\Locales\Eloquent\CountryRepository;
use Escape\Argon\Locales\Eloquent\LanguageRepository;
use Escape\Argon\Locales\Eloquent\LocaleRepository;
use Illuminate\Http\Request;
use Input;
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
            ['language', 'country']
        )->all();

        return View::make('argon::locales.manage', ['locales' => $locales]);
    }

    /**
     * @return mixed
     */
    public function create(CountryRepository $countryRepository, LanguageRepository $languageRepository)
    {
        $countries = $countryRepository->all();
        $languages = $languageRepository->all();

        return View::make('argon::locales.create', ['countries' => $countries, 'languages' => $languages]);
    }

    /**
     * @param LocaleRepository $localesRepository
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function save(LocaleRepository $localesRepository)
    {
        $locale = $localesRepository->create(
            Input::all()
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
    public function edit($localeId, LocaleRepository $localesRepository)
    {
        $locale = $localesRepository->find($localeId);

        return View::make('argon::locales.edit', ['locale' => $locale]);
    }

    /**
     * @param $localeId
     * @param LocaleRepository $localesRepository
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update($localeId, LocaleRepository $localesRepository)
    {
        $localesRepository->update(Input::all(), $localeId);

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
