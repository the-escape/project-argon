<?php

namespace Escape\Argon\Core\Controllers;

use Escape\Argon\Events\AdminAccess;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use View;

abstract class BaseController extends Controller
{
    use DispatchesJobs, ValidatesRequests;

    protected $request;

    public function __construct(Request $request)
    {
        $this->middleware('auth', ['except' => ['showLoginForm', 'login', 'forgotPassword']]);

        $this->adminAccessEvent($request);

        $this->middleware(function ($request, $next) {
            View::share('currentUser', $request->user());
            View::share('plugins', app('pluginManager'));

            $this->request = $request;
            return $next($request);
        });
    }

    public function adminAccessEvent(Request $request)
    {
        $event = event(new AdminAccess($request));

        if(!empty($event[0]->middleware))
        {
            foreach ($event[0]->middleware as $middleware)
            {
                $this->middleware($middleware);
            }
        }

        return;
    }
}
