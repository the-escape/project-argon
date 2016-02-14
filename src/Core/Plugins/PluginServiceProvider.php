<?php

namespace Escape\Argon\Core\Plugins;

use Escape\Argon\Core\Plugins\PluginManager;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class PluginServiceProvider extends ServiceProvider
{
    public function register()
    {

    }

    public function boot()
    {
        $this->app->singleton('pluginManager', function () {
            return new PluginManager();
        });

        $this->app->singleton('javascriptManager', function () {
            return new JavascriptManager($this->app[Request::class]);
        });

        view()->share('javascriptManager', $this->app['javascriptManager']);
    }
}
