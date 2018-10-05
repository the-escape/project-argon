<?php

namespace Escape\Argon\Locales\Controllers;

use Escape\Argon\Core\Controllers\BaseController;
use Escape\Argon\Locales\Eloquent\MultiDomainRepository;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Input;
use Lang;
use Redirect;

class MultiDomainController extends BaseController
{
    /**
     * LocalesController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->middleware('perm:cms:login');
        $this->middleware('perm:cms:multiDomain:manage');

        parent::__construct($request);
    }

    /**
     * @param MultiDomainRepository $multiDomainRepository
     * @return mixed
     */
    public function manage(MultiDomainRepository $multiDomainRepository)
    {
        $multiDomain = $multiDomainRepository->all();

        return View::make('argon::multiDomain.manage', ['multiDomain' => $multiDomain]);
    }

    /**
     * @param MultiDomainRepository $multiDomainRepository
     * @return mixed
     */
    public function create(MultiDomainRepository $multiDomainRepository)
    {
        return View::make('argon::multiDomain.create');
    }

    /**
     * @param MultiDomainRepository $multiDomainRepository
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function save(MultiDomainRepository $multiDomainRepository)
    {
      $multiDomainRepository->create(
            Input::all()
        );

        return Redirect::route('cms:multiDomain:manage');
    }

    /**
     * @param $regionId
     * @param MultiDomainRepository $multiDomainRepository
     * @return mixed
     */
    public function delete($regionId, MultiDomainRepository $multiDomainRepository)
    {
      $multiDomainRepository->delete($regionId);

        return Redirect::route('cms:multiDomain:manage');
    }

    /**
     * @param $regionId
     * @param MultiDomainRepository $multiDomainRepository
     * @return mixed
     */
    public function edit($regionId, MultiDomainRepository $multiDomainRepository)
    {
        $region = $multiDomainRepository->find($regionId)->with([
            'locale'
        ])->first();

        return View::make('argon::multiDomain.edit', ['region' => $region]);
    }

    /**
     * @param $regionId
     * @param MultiDomainRepository $multiDomainRepository
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update($regionId, MultiDomainRepository $multiDomainRepository)
    {
      $multiDomainRepository->update(Input::all(), $regionId);

        return Redirect::route('cms:multiDomain:manage')
            ->with('message', Lang::get('argon-locales::multiDomain.saved'));
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
