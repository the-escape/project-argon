<?php

namespace Escape\Argon\Navigation\Controllers;

use Escape\Argon\Core\Controllers\BaseController;
use Illuminate\Http\Request;

class NavigationController extends BaseController
{
    public function manage()
    {
        return view('argon_navigation::manage', []);
    }

    public function save(Request $request)
    {

        dd($request->all());

    }
}
