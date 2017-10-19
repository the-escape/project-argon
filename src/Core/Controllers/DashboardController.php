<?php

namespace Escape\Argon\Core\Controllers;

use Escape\Argon\Core\Controllers\BaseController;
use Escape\Argon\Events\AdminAccess;
use Illuminate\Http\Request;
use Mockery\Exception;
use View;
use Slack;
use Auth;

class DashboardController extends BaseController
{
    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->middleware('perm:cms:login');
        parent::__construct($request);
    }

    public function dashboard(Request $request)
    {
        return View::make('argon::page.overview', []);
    }
}
