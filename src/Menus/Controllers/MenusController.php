<?php

namespace Escape\Argon\Menus\Controllers;

use Escape\Argon\Core\Controllers\BaseController;
use Escape\Argon\Menus\Eloquent\Menu;
use Escape\Argon\Menus\Eloquent\MenuRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MenusController extends BaseController
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->middleware('perm:cms:menus:manage');

        parent::__construct($request);
    }

    public function manage(MenuRepository $menuRepository)
    {
        $menus = $menuRepository->all();
        return view('argon_menus::manage', ['menus' => $menus]);
    }

    public function create()
    {
        return view('argon_menus::create');
    }

    public function edit()
    {
        return view('argon_menus::edit', []);
    }

    public function save(Request $request)
    {

        $rules = [
            'name' => 'required',
            'slug' => 'required',
            'menu' => 'required',
        ];

        $validator = $this->getValidationFactory()->make($request->all(), $rules, $messages=[], $customAttributes=[]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->messages()->all(),
            ], Response::HTTP_BAD_REQUEST);
        }

        $jsonMenu = $request->get('menu');

        // json key is required
        if (is_null($jsonMenu))
        {
            return response()->json([
                'success'=> false,
            ], Response::HTTP_BAD_REQUEST);
        }

        // save menu
        $menu = Menu::create($request->all());

        if (!$menu)
        {
            return response()->json([
                'success'=> false,
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }


        return response()->json([
            'success'=> true,
        ], Response::HTTP_OK);
    }
}
