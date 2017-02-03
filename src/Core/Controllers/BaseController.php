<?php

namespace Escape\Argon\Core\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

abstract class BaseController extends Controller
{
    use DispatchesJobs, ValidatesRequests;

    protected $name;

    public function __construct()
    {
        $this->addMiddleware();
    }

    abstract function setMiddleware();

    private function addMiddleware()
    {
        $middleware = /*['auth'] +*/ $this->setMiddleware();

        foreach ($middleware as $class) {
            $this->middleware($class);
        }
    }

    public function addTabs(array $tabs)
    {
        $html = '';

        foreach ($tabs as $tab) {
            $html .= view('argon::partials.tab')->with(compact('tab'))->render();
        }

        view()->share('tabs', $html);
    }
}
