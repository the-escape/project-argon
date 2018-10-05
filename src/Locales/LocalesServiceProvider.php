<?php

namespace Escape\Argon\Locales;

use Escape\Argon\Core\Plugins\AbstractPluginServiceProvider;
use Escape\Argon\Locales\Controllers\LocalesController;
use Escape\Argon\Locales\Controllers\MultiDomainController;
use Escape\Argon\Locales\Controllers\RegionsController;
use Illuminate\Http\Request;

class LocalesServiceProvider extends AbstractPluginServiceProvider
{
    protected $name = 'Locales';

    /**
     * @throws \Exception
     */
    public function registerRoutes()
    {
        // LOCALES
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

        // REGIONS
        $this->addRoute(
            'regions',
            'cms:regions:manage',
            RegionsController::class,
            'manage'
        );
        $this->addRoute(
            'regions/create',
            'cms:regions:create',
            RegionsController::class,
            'create'
        );
        $this->addRoute(
            'regions/create',
            'cms:regions:create',
            RegionsController::class,
            'save',
            Request::METHOD_POST
        );
        $this->addRoute(
            'regions/{regionId}/edit',
            'cms:regions:edit',
            RegionsController::class,
            'edit'
        );
        $this->addRoute(
            'regions/{regionId}/edit',
            'cms:regions:edit',
            RegionsController::class,
            'update',
            Request::METHOD_POST
        );
        $this->addRoute(
            'regions/{regionId}/delete',
            'cms:regions:delete',
            RegionsController::class,
            'delete'
        );

        // MULTI-DOMAIN
        $this->addRoute(
            'multidomain',
            'cms:multiDomain:manage',
            MultiDomainController::class,
            'manage'
        );
        $this->addRoute(
            'multidomain/create',
            'cms:multiDomain:create',
            MultiDomainController::class,
            'create'
        );
        $this->addRoute(
            'multidomain/create',
            'cms:multiDomain:create',
            MultiDomainController::class,
            'save',
            Request::METHOD_POST
        );
        $this->addRoute(
            'multidomain/{regionId}/edit',
            'cms:multiDomain:edit',
            MultiDomainController::class,
            'edit'
        );
        $this->addRoute(
            'multidomain/{multiDomainId}/edit',
            'cms:multiDomain:edit',
            MultiDomainController::class,
            'update',
            Request::METHOD_POST
        );
        $this->addRoute(
            'multidomain/{multiDomainId}/delete',
            'cms:multiDomain:delete',
            MultiDomainController::class,
            'delete'
        );
    }

    public function startup()
    {
        $this->loadViewsFrom(__DIR__ . '/Views', 'argon');

        $this->permissionsManager->register('cms:locale:manage');
        $this->pluginManager->registerNavLink('Locales', route('cms:locales:manage'), 'cms:locale:manage');

        $this->permissionsManager->register('cms:regions:manage');
        $this->pluginManager->registerNavLink('Regions', route('cms:regions:manage'), 'cms:region:manage');

        $this->permissionsManager->register('cms:multiDomain:manage');
        $this->pluginManager->registerNavLink('Multi Domain', route('cms:multiDomain:manage'), 'cms:multiDomain:manage');

        $this->publishes([
            __DIR__ . '/Migrations' => database_path('migrations'),
        ], 'migrations');
    }
}
