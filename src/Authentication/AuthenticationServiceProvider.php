<?php

namespace Escape\Argon\Authentication;

use Escape\Argon\Core\Plugins\AbstractPluginServiceProvider;
use Escape\Argon\EntityManagement\FieldTypes\FieldTypesManager;
use Escape\Argon\Authentication\Controllers\ForgotPasswordController;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Auth\Access\Gate;

class AuthenticationServiceProvider extends AbstractPluginServiceProvider
{
    protected $name = 'authentication';

    protected function registerRoutes()
    {
        $this->addRoute(
            'forgot-password',
            'cms:authentication:forgot-password',
            ForgotPasswordController::class,
            'index',
            'GET'
        );

        $this->addRoute(
            'forgot-password',
            'cms:authentication:forgot-password',
            ForgotPasswordController::class,
            'create',
            'POST'
        );
    }

    public function boot()
    {
        $this->app->singleton('permissions', function () {
            return new PermissionManager($this->app->make(Gate::class));
        });

        $this->app->bind(PermissionManager::class, 'permissions');

        $this->app->singleton('fieldTypes', function () {
            return new FieldTypesManager();
        });

        $this->app->bind(FieldTypesManager::class, 'fieldTypes');

        parent::boot();
    }

    public function startup()
    {
        $router = $this->app['router'];
        $router->middleware('auth', Middleware\Authenticate::class);
        $router->middleware('role', Middleware\AssertRole::class);
        $router->middleware('perm', Middleware\AssertPermission::class);

        $this->loadTranslationsFrom(__DIR__ . '/lang/', 'argon-auth');
    }
}
