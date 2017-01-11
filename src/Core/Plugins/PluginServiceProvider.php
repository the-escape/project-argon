<?php

namespace Escape\Argon\Core\Plugins;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class PluginServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        $this->app->singleton('pluginManager', function () {
            return new PluginManager();
        });

        $this->app->singleton('assetsManager', function () {
            return new AssetsManager($this->app[Request::class]);
        });

        view()->share('assetsManager', $this->app['assetsManager']);
    }
}
