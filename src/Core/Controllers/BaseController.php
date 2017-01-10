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
        $this->addTabs();
    }

    abstract function setMiddleware();
    abstract function setTabs();

    private function addMiddleware()
    {
        $middleware = ['auth'] + $this->setMiddleware();

        foreach ($middleware as $class) {
            $this->middleware($class);
        }
    }

    private function addTabs()
    {
        $tabs = '';

        foreach ($this->setTabs() as $tab) {
            $tabs .= view('argon::partials.tab')->with(compact('tab'))->render();
        }

        view()->share('tabs', $tabs);
    }
}
