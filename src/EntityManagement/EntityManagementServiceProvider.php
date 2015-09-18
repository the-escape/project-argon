<?php

namespace Escape\Argon\EntityManagement;

use Escape\Argon\Authentication\PermissionManager;
use Escape\Argon\Core\Plugins\AbstractPluginServiceProvider;
use Escape\Argon\Core\Plugins\PluginManager;
use Escape\Argon\EntityManagement\Controllers\PagesController;
use Escape\Argon\EntityManagement\Controllers\EntityTypeController;
use Escape\Argon\EntityManagement\FieldTypes\FieldTypesManager;
use Escape\Argon\EntityManagement\FieldTypes\TextFieldType;
use Faker\Provider\de_DE\Text;
use Illuminate\Http\Request;

class EntityManagementServiceProvider extends AbstractPluginServiceProvider
{
    protected $name = 'Content';

    protected function registerRoutes()
    {
        // Pages
        $this->addRoute(
            'pages',
            'cms:pages:manage',
            PagesController::class,
            'manage'
        );
        $this->addRoute(
            'pages/{id}/addchild/{type}',
            'cms:content:create',
            PagesController::class,
            'create'
        );
        $this->addRoute(
            'pages/{id}/addchild/{type}',
            'cms:content:save',
            PagesController::class,
            'save',
            Request::METHOD_POST
        );
        $this->addRoute(
            'pages/{id}/edit',
            'cms:pages:edit',
            PagesController::class,
            'edit'
        );
        $this->addRoute(
            'pages/{id}/edit',
            'cms:pages:update',
            PagesController::class,
            'update',
            Request::METHOD_POST
        );

        // Types
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

        $this->addRoute(
            'types/{typeId}/fields/add',
            'cms:types:fields:add',
            EntityTypeController::class,
            'addField'
        );

        $this->addRoute(
            'types/{typeId}/fields/add',
            'cms:types:fields:save',
            EntityTypeController::class,
            'saveField',
            Request::METHOD_POST
        );

        $this->addRoute(
            'types/{typeId}/fields/{fieldId}/edit',
            'cms:types:fields:edit',
            EntityTypeController::class,
            'editField'
        );

        $this->addRoute(
            'types/{typeId}/fields/{fieldId}/edit',
            'cms:types:fields:update',
            EntityTypeController::class,
            'updateField',
            Request::METHOD_POST
        );
    }

    public function boot()
    {
        $this->app->singleton('fieldTypes', function () {
            return new FieldTypesManager();
        });

        $this->app->bind(FieldTypesManager::class, 'fieldTypes');

        parent::boot();
    }

    public function startup()
    {
        $this->loadViewsFrom(__DIR__ . '/Views', 'argon');

        $this->permissionsManager->register('cms:entity:type:manage');
        $this->permissionsManager->register('cms:entity:type:create');
        $this->permissionsManager->register('cms:entity:type:edit');
        $this->permissionsManager->register('cms:content:manage');

        $this->loadTranslationsFrom(__DIR__ . '/lang', 'argon-entities');

        $this->publishes([
            __DIR__ . '/Migrations' => database_path('migrations'),
        ], 'migrations');

        $this->pluginManager->registerNavLink('Pages', route('cms:pages:manage'), 'cms:content:manage');
//        $this->pluginManager->registerNavLink('Collections', route('cms:pages:manage'), 'cms:content:manage');
        $this->pluginManager->registerNavLink('Content Types', route('cms:types:manage'), 'cms:entity:type:manage');

        $this->fieldTypesManager->registerFieldType(new TextFieldType());
    }
}
