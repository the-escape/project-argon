<?php

namespace Escape\Argon\Locales;

use Escape\Argon\Core\Plugins\AbstractPluginServiceProvider;
use Escape\Argon\Locales\Controllers\LocalesController;
use Illuminate\Http\Request;

class LocalesServiceProvider extends AbstractPluginServiceProvider
{
    protected $name = 'Locales';

    public function registerRoutes()
    {
        $this->addRoute(
            'locales',
            'cms:locales:manage',
            LocalesController::class,
            'manage'
        );
        $this->addRoute(
            'locales/create',
            'cms:locales:create',
            LocalesController::class,
            'create'
        );
        $this->addRoute(
            'locales/create',
            'cms:locales:create',
            LocalesController::class,
            'save',
            Request::METHOD_POST
        );
        $this->addRoute(
            'locales/{localeId}/edit',
            'cms:locales:edit',
            LocalesController::class,
            'edit'
        );
        $this->addRoute(
            'locales/{localeId}/edit',
            'cms:locales:edit',
            LocalesController::class,
            'update',
            Request::METHOD_POST
        );
        $this->addRoute(
            'locales/{localeId}/delete',
            'cms:locales:delete',
            LocalesController::class,
            'delete'
        );
        $this->addRoute(
            'locales/set/{localeId}',
            'cms:locales:set',
            LocalesController::class,
            'set'
        );
    }

    public function startup()
    {
        $this->loadViewsFrom(__DIR__ . '/Views', 'argon');

        $this->permissionsManager->register('cms:locale:manage');

        $this->pluginManager->registerNavLink('Locales', route('cms:locales:manage'), 'cms:locale:manage', 'pages');

        $this->publishes([
            __DIR__ . '/Migrations' => database_path('migrations'),
        ], 'migrations');
    }
}
