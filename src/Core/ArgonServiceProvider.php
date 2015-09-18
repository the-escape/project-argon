<?php

namespace Escape\Argon\Core;

use Escape\Argon\Authentication\AuthenticationServiceProvider;
use Escape\Argon\Core\Plugins\PluginServiceProvider;
use Escape\Argon\EntityManagement\EntityManagementServiceProvider;
use Escape\Argon\Locales\LocalesServiceProvider;
use Escape\Argon\UserManagement\UserManagementServiceProvider;
use Illuminate\Support\ServiceProvider;
use Prettus\Repository\Providers\RepositoryServiceProvider;

class ArgonServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (!$this->app->routesAreCached()) {
            require __DIR__ . '/../../routes.php';
        }

        $this->loadViewsFrom(__DIR__ . '/../../views', 'argon');

        $this->publishes([
            __DIR__.'/../../public' => public_path('argon'),
        ], 'public');

        $this->publishes([
            __DIR__.'/../../migrations' => database_path('migrations'),
        ], 'migrations');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/argon.php', 'argon');

        $this->app->register(RepositoryServiceProvider::class);
        $this->app->register(AuthenticationServiceProvider::class);
        $this->app->register(PluginServiceProvider::class);
        $this->app->register(EntityManagementServiceProvider::class);
        $this->app->register(UserManagementServiceProvider::class);
        $this->app->register(LocalesServiceProvider::class);
    }
}
