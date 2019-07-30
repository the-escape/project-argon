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
        // dd(auth());
        if(legacyLv())
        {
            $router->middleware('auth', Middleware\Authenticate::class);
            $router->middleware('role', Middleware\AssertRole::class);
            $router->middleware('perm', Middleware\AssertPermission::class);
        }
        else
        {
            $router->aliasMiddleware('auth', Middleware\Authenticate::class);
            $router->aliasMiddleware('role', Middleware\AssertRole::class);
            $router->aliasMiddleware('perm', Middleware\AssertPermission::class);
        }

        // Replace the AuthManager class with one of ours.
//        AliasLoader::getInstance()->alias('Auth', Auth);

        $this->app->singleton('permissions', function () {
            return new PermissionManager($this->app->make('Illuminate\\Contracts\\Auth\\Access\\Gate'));
        });

        /** @var PermissionManager $permissions */
        $permissions = $this->app['permissions'];

        $permissions->register('cms:login');

        $this->loadTranslationsFrom(__DIR__ . '/lang/', 'argon-auth');

        $this->publishes([
            __DIR__ . '/Listeners' => app_path('Listeners'),
        ], 'listeners');
    }

    public function register()
    {
    }
}
