<?php

namespace Escape\Argon\Locales\Controllers;

use Escape\Argon\Core\Controllers\BaseController;
use Escape\Argon\Locales\Eloquent\LocaleRepository;
use Escape\Argon\Locales\Eloquent\MultiDomainRepository;
use Illuminate\Http\Request;
use Lang;
use Redirect;
use View;

class MultiDomainController extends BaseController
{
    /**
     * LocalesController constructor.
     *
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
     *
     * @return mixed
     */
    public function manage(MultiDomainRepository $multiDomainRepository)
    {
        $domain = $multiDomainRepository->all();

        return View::make('argon::multidomain.manage', ['domains' => $domain]);
    }

  /**
   * @param MultiDomainRepository $multiDomainRepository
   * @param LocaleRepository $localeRepository
   *
   * @return mixed
   */
    public function create(MultiDomainRepository $multiDomainRepository, LocaleRepository $localeRepository)
    {
        $locales = $localeRepository->all();

        return View::make('argon::multidomain.create', ['locales' => $locales]);
    }

    /**
     * @param MultiDomainRepository $multiDomainRepository
     *
     * @return mixed
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function save(MultiDomainRepository $multiDomainRepository)
    {
      $multiDomainRepository->create(
            $this->request->all()
        );

        return Redirect::route('cms:multiDomain:manage');
    }

    /**
     * @param $regionId
     * @param MultiDomainRepository $multiDomainRepository
     *
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
   * @param LocaleRepository $localeRepository
   *
   * @return mixed
   */
    public function edit($regionId, MultiDomainRepository $multiDomainRepository, LocaleRepository $localeRepository)
    {
        $domain = $multiDomainRepository->find($regionId)->with([
            'locale'
        ])->first();

        $locales = $localeRepository->all();

        return View::make('argon::multidomain.edit', ['domain' => $domain, 'locales' => $locales]);
    }

    /**
     * @param $regionId
     * @param MultiDomainRepository $multiDomainRepository
     *
     * @return mixed
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update($regionId, MultiDomainRepository $multiDomainRepository)
    {
      $multiDomainRepository->update($this->request->all(), $regionId);

          return Redirect::route('cms:multiDomain:manage')
              ->with('message', Lang::get('argon-locales::multiDomain.saved'));
    }

    /**
     * @param $regionId
     * @param Request $request
     *
     * @return mixed
     */
    public function set($regionId, Request $request)
    {
        $request->session()->put('region', $regionId);

        $returnUrl = $request->get('return');

        return Redirect::to($returnUrl);
    }
}
