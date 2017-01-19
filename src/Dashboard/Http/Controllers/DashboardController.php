<?php

namespace Escape\Argon\Dashboard\Http\Controllers;

use Escape\Argon\Core\Controllers\BaseController;

class DashboardController extends BaseController
{
    function setMiddleware()
    {
        return [
            'auth',
            'perm:cms:login',
        ];
    }

    function setTabs()
    {
        return [];
    }

    public function index()
    {
        return view('argon.dashboard::pages.index');
    }
}
