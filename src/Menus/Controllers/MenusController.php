<?php

namespace Escape\Argon\Menus\Controllers;

use Escape\Argon\Core\Controllers\BaseController;
use Escape\Argon\Locales\Eloquent\LocaleRepository;
use Escape\Argon\Menus\Eloquent\Menu;
use Escape\Argon\Menus\Eloquent\MenuRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class MenusController extends BaseController
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->middleware('perm:cms:menus:manage');

        parent::__construct($request);
    }

    public function manage(MenuRepository $menuRepository, LocaleRepository $localeRepository)
    {
        $menus = $menuRepository->all();
        $locales = $localeRepository->all();

        return view('argon_menus::manage', ['menus' => $menus, 'locales' => $locales]);
    }

    public function create(LocaleRepository $localeRepository)
    {
        $locales = $localeRepository->all();

        return view('argon_menus::create', ['locales' => $locales]);
    }

    public function save(Request $request)
    {
        // use submitted slug or auto-generate from name
        $slug = str_slug(($input_slug = $request->input('slug')) ? $input_slug : $request->input('name'));

        $request->merge(['slug' => $slug]);

        $rules = [
            'name' => "required",
            'slug' => "required|unique:menus,slug,NULL,id,deleted_at,NULL,locale_id,{$request->input('locale_id')}",
            'menu' => 'required', // perhaps validate json?
        ];

        $this->validate($request, $rules, $messages=[], $customAttributes=[]);

        $menu = Menu::create($request->all());

        if (!$menu)
        {
            return redirect(route('cms:menus:create'), Response::HTTP_INTERNAL_SERVER_ERROR)
                ->withErrors(["There war a problem. Please try again."]);
        }

        return redirect(route('cms:menus:edit', ["id" => $menu->id]));
    }

    public function edit($id, MenuRepository $menuRepository, LocaleRepository $localeRepository)
    {
        $menu = $menuRepository->find($id);
        $locales = $localeRepository->all();

        return view('argon_menus::edit', ['menu' => $menu, 'locales' => $locales]);
    }

    public function update($id, Request $request, MenuRepository $menuRepository)
    {
        // use submitted slug or auto-generate from name
        $slug = str_slug(($input_slug = $request->input('slug')) ? $input_slug : $request->input('name'));

        $request->merge(['slug' => $slug]);

        $rules = [
            'name' => "required",
            'slug' => "required|unique:menus,slug,{$id},id,deleted_at,NULL,locale_id,{$request->input('locale_id')}",
            'menu' => 'required', // perhaps validate json?
        ];

        $this->validate($request, $rules, $messages=[], $customAttributes=[]);

        $menu = $menuRepository->update($request->all(), $id);

        return redirect(route('cms:menus:edit', ['id' => $menu->id]))->with('message', "Menu updated.");
    }

    public function delete($id, MenuRepository $menuRepository)
    {
        $menuRepository->delete($id);

        return redirect(route('cms:menus:manage'), Response::HTTP_NO_CONTENT);
    }
}
