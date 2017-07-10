<?php

namespace Escape\Argon\Locale;

use Escape\Argon\Core\Plugins\AbstractPluginServiceProvider;
use Escape\Argon\Locale\Controllers\LocalesController;
use Illuminate\Http\Request;

class LocaleServiceProvider extends AbstractPluginServiceProvider
{
    protected $name = 'Locale';

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

        $this->pluginManager->registerNavLink('Locale', route('cms:locales:manage'), 'cms:locale:manage');

        $this->publishes([
            __DIR__ . '/Migrations' => database_path('migrations'),
        ], 'migrations');
    }
}
