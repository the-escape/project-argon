<?php

namespace Escape\Argon\Core\Controllers;

use Escape\Argon\Core\Controllers\BaseController;
use Illuminate\Http\Request;
use View;

class DashboardController extends BaseController
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->middleware('perm:cms:login');
        parent::__construct($request);
    }

    public function dashboard()
    {
        return View::make('argon::page.overview', []);
    }

}