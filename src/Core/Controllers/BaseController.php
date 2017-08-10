<?php

namespace Escape\Argon\Core\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use View;

abstract class BaseController extends Controller
{
    use DispatchesJobs, ValidatesRequests;

    protected $request;
    protected $pluginManager;
    protected $currentUser;

    public function __construct(Request $request)
    {
        $this->middleware('auth', ['except' => ['getLogin', 'postLogin', 'forgotPassword']]);

        View::share('currentUser', $request->user());
        View::share('plugins', app('pluginManager'));

        $this->currentUser = $request->user();
        $this->pluginManager = app('pluginManager');
        $this->request = $request;
    }
}
