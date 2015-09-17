<?php

namespace Escape\Argon\EntityManagement;

use Escape\Argon\Authentication\PermissionManager;
use Escape\Argon\Core\Plugins\AbstractPluginServiceProvider;
use Escape\Argon\Core\Plugins\PluginManager;
use Escape\Argon\EntityManagement\Controllers\ContentController;
use Escape\Argon\EntityManagement\Controllers\EntityTypeController;
use Escape\Argon\EntityManagement\FieldTypes\FieldTypesManager;
use Escape\Argon\EntityManagement\FieldTypes\TextFieldType;
use Escape\Argon\EntityManagement\FieldTypes\ImageFieldType;
use Escape\Argon\EntityManagement\FieldTypes\FileFieldType;
use Faker\Provider\de_DE\Text;
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
        $this->addRoute(
            'content/add/{type}',
            'cms:content:create',
            ContentController::class,
            'create'
        );
        $this->addRoute(
            'content/add/{type}',
            'cms:content:save',
            ContentController::class,
            'save',
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


        $this->loadViewsFrom(__DIR__ . '/Views', 'argon');

        /** @var PermissionManager $permissions */
        $permissions = $this->app['permissions'];

        $permissions->register('cms:entity:type:manage');
        $permissions->register('cms:entity:type:create');
        $permissions->register('cms:entity:type:edit');
        $permissions->register('cms:content:manage');

        $this->loadTranslationsFrom(__DIR__ . '/lang', 'argon-entities');

        $this->publishes([
            __DIR__ . '/Migrations' => database_path('migrations'),
        ], 'migrations');

        $this->registerPlugin();
    }

    public function registerPlugin()
    {
        /** @var PluginManager $manager */
        $manager = $this->app['pluginManager'];
        $manager->register($this);

        $manager->registerNavLink('Content', route('cms:content:manage'), 'cms:content:manage');
        $manager->registerNavLink('Content Types', route('cms:types:manage'), 'cms:entity:type:manage');

        /** @var FieldTypesManager $fieldTypes */
        $fieldTypes = $this->app['fieldTypes'];
        $fieldTypes->registerFieldType(new TextFieldType());
        $fieldTypes->registerFieldType(new ImageFieldType());
        $fieldTypes->registerFieldType(new FileFieldType());
    }
}
