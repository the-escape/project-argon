<?php

namespace Escape\Argon\Authentication;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class AuthenticationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Register our Middleware
        /** @var Router $router */
        $router = $this->app['router'];
        $router->middleware('auth', Middleware\Authenticate::class);
        $router->middleware('role', Middleware\AssertRole::class);
        $router->middleware('perm', Middleware\AssertPermission::class);

        // Replace the AuthManager class with one of ours.
//        AliasLoader::getInstance()->alias('Auth', Auth);

        $this->app->singleton('permissions', function () {
            return new PermissionManager();
        });

        /** @var PermissionManager $permissions */
        $permissions = $this->app['permissions'];

        $permissions->register('cms:login');

        $this->loadTranslationsFrom(__DIR__ . '/lang/', 'argon-auth');
    }

    public function register()
    {
    }
}