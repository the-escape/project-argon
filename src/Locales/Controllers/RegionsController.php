<?php

namespace Escape\Argon\Locales\Controllers;

use Escape\Argon\Core\Controllers\BaseController;
use Escape\Argon\Locales\Eloquent\CountryRepository;
use Escape\Argon\Locales\Eloquent\LocaleRepository;
use Escape\Argon\Locales\Eloquent\RegionRepository;
use Illuminate\Http\Request;
use Input;
use Lang;
use League\Flysystem\Adapter\Local;
use Redirect;
use View;

class RegionsController extends BaseController
{
    /**
     * LocalesController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->middleware('perm:cms:login');
        $this->middleware('perm:cms:regions:manage');

        parent::__construct($request);
    }

    /**
     * @param RegionRepository $regionRepository
     * @return mixed
     */
    public function manage(RegionRepository $regionRepository)
    {
        $regions = $regionRepository->all();

        return View::make('argon::regions.manage', ['regions' => $regions]);
    }

    /**
     * @param LocaleRepository $localeRepository
     * @return mixed
     */
    public function create(LocaleRepository $localeRepository)
    {
        return View::make('argon::regions.create');
    }

    /**
     * @param RegionRepository $regionRepository
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function save(RegionRepository $regionRepository)
    {
        $regionRepository->create(
            Input::all()
        );

        return Redirect::route('cms:regions:manage');
    }

    /**
     * @param $regionId
     * @param RegionRepository $regionRepository
     * @return mixed
     */
    public function delete($regionId, RegionRepository $regionRepository)
    {
        $regionRepository->delete($regionId);

        return Redirect::route('cms:regions:manage');
    }

    /**
     * @param $regionId
     * @param RegionRepository $regionRepository
     * @return mixed
     */
    public function edit($regionId, RegionRepository $regionRepository, CountryRepository $countryRepository)
    {
        $region = $regionRepository->find($regionId)->with([
            'locale'
        ])->first();

        return View::make('argon::regions.edit', ['region' => $region]);
    }

    /**
     * @param $regionId
     * @param RegionRepository $regionRepository
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update($regionId, RegionRepository $regionRepository)
    {
        $regionRepository->update(Input::all(), $regionId);

        return Redirect::route('cms:regions:manage')
            ->with('message', Lang::get('argon-locales::region.saved'));
    }

    /**
     * @param $regionId
     * @param Request $request
     * @return mixed
     */
    public function set($regionId, Request $request)
    {
        $request->session()->put('region', $regionId);

        $returnUrl = $request->get('return');

        return Redirect::to($returnUrl);
    }


}
