<?php

namespace Escape\Argon\Redirect;

use Escape\Argon\Core\Http\Requests\Request;
use Escape\Argon\Core\Plugins\AbstractPluginServiceProvider;
use Escape\Argon\Redirect\Controllers\RedirectsController;
use Escape\Argon\Redirect\Middleware\RedirectMiddleware;

class RedirectServiceProvider extends AbstractPluginServiceProvider
{
    protected $name = 'Redirect Management';

    public function registerRoutes()
    {
        $this->addRoute(
            'redirects',
            'cms:redirects:manage',
            RedirectsController::class,
            'manage',
            Request::METHOD_GET
        );
        $this->addRoute(
            'redirects/create',
            'cms:redirects:create',
            RedirectsController::class,
            'create',
            Request::METHOD_GET
        );
        $this->addRoute(
            'redirects/create',
            'cms:redirects:save',
            RedirectsController::class,
            'save',
            Request::METHOD_POST
        );
        $this->addRoute(
            'redirects/{id}',
            'cms:redirects:edit',
            RedirectsController::class,
            'edit',
            Request::METHOD_GET
        );
        $this->addRoute(
            'redirects/{id}',
            'cms:redirects:update',
            RedirectsController::class,
            'update',
            Request::METHOD_PUT
        );
        $this->addRoute(
            'redirects/{id}',
            'cms:redirects:delete',
            RedirectsController::class,
            'delete',
            Request::METHOD_DELETE
        );
    }

    public function boot()
    {
        parent::boot();

        // Register our Middleware
        /** @var Router $router */
        $router = $this->app['router'];
        $router->middleware('redirect', RedirectMiddleware::class);
    }

    public function startup()
    {
        $this->loadViewsFrom(__DIR__ . '/Views', 'argon');

        $this->permissionsManager->register('cms:redirects:manage');

        $this->pluginManager->registerNavLink('Redirect Manager', route('cms:redirects:manage'), 'cms:redirects:manage');

        $this->publishes([
            __DIR__ . '/Migrations' => database_path('migrations'),
        ], 'migrations');
    }
}
