<?php

namespace Escape\Argon\Core\Plugins;

use Escape\Argon\Core\Plugins\PluginManager;
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
    }
}
