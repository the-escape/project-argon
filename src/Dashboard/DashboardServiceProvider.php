<?php

namespace Escape\Argon\Dashboard;

use Escape\Argon\Core\Plugins\AbstractPluginServiceProvider;
use Escape\Argon\Dashboard\Http\Controllers\DashboardController;

class DashboardServiceProvider extends AbstractPluginServiceProvider
{
    protected $name = 'Dashboard';

    protected function registerRoutes()
    {
        $this->addRoute(
            '/',
            'cms:dashboard:index',
            DashboardController::class,
            'index'
        );
    }

    public function startup()
    {
        $this->loadViewsFrom(__DIR__.'/resources/views', 'argon.dashboard');
    }
}
