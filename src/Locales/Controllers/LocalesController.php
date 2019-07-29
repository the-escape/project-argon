<?php

namespace Escape\Argon\Locales\Controllers;

use Escape\Argon\Core\Controllers\BaseController;
use Escape\Argon\Locales\Eloquent\LocaleRepository;
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

    public function manage(Request $request, LocaleRepository $localeRepository)
    {
        $perPage = $request->input('perpage', 25);
        $orderBy = $request->input('order', 'id');
        $orderDir = $request->input('dir', 'asc');

        $model = $localeRepository->model();
        $query = $model::orderBy($orderBy, $orderDir);

        if ($search = $request->input('keywords'))
        {
            $search = trim($search);
            $query = $query->where(function($q) use ($search) {
                $q->where('email', 'LIKE', "%{$search}%")
                    ->orWhere('name', 'LIKE', "%{$search}%");
            });
        }

        if ($request->has('order'))
        {
            $query = $this->getOrder($query, $request);
        }

        $locales = $query->paginate($perPage);

        return View::make('argon::locales.manage', ['locales' => $locales]);
    }

    public function create()
    {
        return View::make('argon::locales.create');
    }

    public function save(LocaleRepository $localesRepository, Request $request)
    {
        $locale = $localesRepository->create(
            $request->all()
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

    public function update($localeId, LocaleRepository $localesRepository, Request $request)
    {
        $localesRepository->update($request->all(), $localeId);

        return Redirect::route('cms:locales:manage')
            ->with('message', Lang::get('argon-locales::locale.saved'));

    }

    public function set($localeId, Request $request)
    {
        $request->session()->put('locale', $localeId);

        $returnUrl = $request->get('return');

        return Redirect::to($returnUrl);
    }

    private function getOrder($query, Request $request)
    {
        $dir = (in_array($request->input('dir'), ['asc', 'desc'])) ? $request->input('dir') : 'asc';

        switch ($request->input('order'))
        {
            case 'id':
                $query = $query->orderBy('id', $dir);
                break;

            case 'name':
                $query = $query->orderBy('name', $dir);
                break;

            case 'languageCode':
                $query = $query->orderBy('languageCode', $dir);
                break;

            case 'region':
                $query = $query->orderBy('region', $dir);
                break;

            default:
                throw new RuntimeException('Unknown order argument!');
        }

        return $query;
    }
}
