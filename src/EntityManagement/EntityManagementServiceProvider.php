<?php

namespace Escape\Argon\EntityManagement;

use Escape\Argon\Authentication\PermissionManager;
use Escape\Argon\Core\Plugins\AbstractPluginServiceProvider;
use Escape\Argon\Core\Plugins\PluginManager;
use Escape\Argon\EntityManagement\Controllers\ContentController;
use Escape\Argon\EntityManagement\Controllers\EntityTypeController;
use Illuminate\Http\Request;

class EntityManagementServiceProvider extends AbstractPluginServiceProvider
{
    protected $name = 'Content';

    public function register()
    {
        $this->addRoute(
            'content',
            'cms:content:manage',
            ContentController::class,
            'manage'
        );

        //
        $this->addRoute(
            'types',
            'cms:types:manage',
            EntityTypeController::class,
            'manage'
        );
        $this->addRoute(
            'types/create',
            'cms:types:create',
            EntityTypeController::class,
            'create'
        );
        $this->addRoute(
            'types/create',
            'cms:types:create',
            EntityTypeController::class,
            'save',
            Request::METHOD_POST
        );
        $this->addRoute(
            'types/{typeId}/edit',
            'cms:types:edit',
            EntityTypeController::class,
            'edit'
        );
        $this->addRoute(
            'types/{typeId}/delete',
            'cms:types:delete',
            EntityTypeController::class,
            'delete'
        );
        $this->addRoute(
            'types/{typeId}/edit',
            'cms:types:update',
            EntityTypeController::class,
            'update',
            Request::METHOD_POST
        );
    }

    public function boot()
    {
        /** @var PluginManager $pluginManager */
        $pluginManager = $this->app['pluginManager'];

        $pluginManager->register($this);

        $this->loadViewsFrom(__DIR__ . '/Views', 'argon');

        /** @var PermissionManager $permissions */
        $permissions = $this->app['permissions'];

        $permissions->register('cms:entity:type:manage');
        $permissions->register('cms:entity:type:create');
        $permissions->register('cms:entity:type:edit');
        $permissions->register('cms:content:manage');

        $this->loadTranslationsFrom(__DIR__ . '/lang', 'argon-entities');

        $this->publishes([
            __DIR__.'/Migrations' => database_path('migrations'),
        ], 'migrations');

    }

    public function registerPlugin(PluginManager $manager)
    {
        $manager->registerNavLink('Content', route('cms:content:manage'), 'cms:content:manage');
        $manager->registerNavLink('Content Types', route('cms:types:manage'), 'cms:entity:type:manage');
    }
}
