<?php

namespace Escape\Argon\Auth;

use Escape\Argon\Auth\Http\Controllers\ResetPasswordController;
use Escape\Argon\Core\Plugins\AbstractPluginServiceProvider;
use Escape\Argon\Entity\FieldTypes\FieldTypesManager;
use Escape\Argon\Auth\Http\Controllers\ForgotPasswordController;

use Illuminate\Contracts\Auth\Access\Gate;

class AuthServiceProvider extends AbstractPluginServiceProvider
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

        $this->addRoute(
            'reset-password/{token?}',
            'cms:authentication:reset-password',
            ResetPasswordController::class,
            'index',
            'GET'
        );

        $this->addRoute(
            'reset-password',
            'cms:authentication:reset-password',
            ResetPasswordController::class,
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

        $permissions = $this->app['permissions'];

        $permissions->register('cms:login');

        $this->app->singleton('fieldTypes', function () {
            return new FieldTypesManager();
        });

        $this->app->bind(FieldTypesManager::class, 'fieldTypes');

        parent::boot();
    }

    public function startup()
    {
        $router = $this->app['router'];
        $router->middleware('auth', Http\Middleware\Authenticate::class);
        $router->middleware('role', Http\Middleware\AssertRole::class);
        $router->middleware('perm', Http\Middleware\AssertPermission::class);

        $this->loadViewsFrom(__DIR__.'/resources/views/', 'argon.auth');
        $this->loadTranslationsFrom(__DIR__.'/resources/lang/', 'argon.auth');
    }
}
