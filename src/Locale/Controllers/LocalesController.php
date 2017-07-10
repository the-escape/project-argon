<?php

namespace Escape\Argon\Locale\Controllers;

use Escape\Argon\Core\Controllers\BaseController;
use Escape\Argon\Locale\Eloquent\LocaleRepository;
use Illuminate\Http\Request;
use Input;
use Lang;
use Redirect;
use View;

class LocalesController extends BaseController
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->middleware('perm:cms:login');
        $this->middleware('perm:cms:locale:manage');

        parent::__construct($request);
    }

    public function manage(LocaleRepository $localeRepository)
    {
        $locales = $localeRepository->all();
        return View::make('argon::locales.manage', ['locales' => $locales]);
    }

    public function create()
    {
        return View::make('argon::locales.create');
    }

    public function save(LocaleRepository $localesRepository)
    {
        $locale = $localesRepository->create(
            Input::all()
        );

        return Redirect::route('cms:locales:manage');
    }

    public function delete($localeId, LocaleRepository $localesRepository)
    {
        $localesRepository->delete($localeId);

        return Redirect::route('cms:locales:manage');
    }

    public function edit($localeId, LocaleRepository $localesRepository)
    {
        $locale = $localesRepository->find($localeId);

        return View::make('argon::locales.edit', ['locale' => $locale]);
    }

    public function update($localeId, LocaleRepository $localesRepository)
    {
        $localesRepository->update(Input::all(), $localeId);

        return Redirect::route('cms:locales:manage')
            ->with('message', Lang::get('argon-locales::locale.saved'));

    }

    public function set($localeId, Request $request)
    {
        $request->session()->put('locale', $localeId);

        $returnUrl = $request->get('return');

        return Redirect::to($returnUrl);
    }
}
