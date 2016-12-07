<?php

namespace Escape\Argon\EntityManagement;

use Escape\Argon\Core\Plugins\AbstractPluginServiceProvider;
use Escape\Argon\EntityManagement\Controllers\BlocksController;
use Escape\Argon\EntityManagement\Controllers\PagesController;
use Escape\Argon\EntityManagement\Controllers\EntityTypeController;
use Escape\Argon\EntityManagement\Controllers\SitemapController;
use Escape\Argon\EntityManagement\FieldTypes\ComboFieldType;
use Escape\Argon\EntityManagement\FieldTypes\FieldTypesManager;
use Escape\Argon\EntityManagement\FieldTypes\TextFieldType;
use Escape\Argon\EntityManagement\FieldTypes\ImageFieldType;
use Escape\Argon\EntityManagement\FieldTypes\FileFieldType;
use Escape\Argon\EntityManagement\FieldTypes\VideoFieldType;
use Escape\Argon\EntityManagement\FieldTypes\BooleanFieldType;
use Escape\Argon\EntityManagement\FieldTypes\ItemFieldType;
use Escape\Argon\EntityManagement\FieldTypes\WysiwygFieldType;
use Escape\Argon\EntityManagement\FieldTypes\DatetimeFieldType;
use Escape\Argon\EntityManagement\FieldTypes\ColourpickerFieldType;
use Escape\Argon\EntityManagement\FieldTypes\LocationFieldType;
use Escape\Argon\EntityManagement\FieldTypes\SelectFieldType;
use Escape\Argon\EntityManagement\FieldTypes\UserFieldType;
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
            'pages/{id}/addchild/{typeId}',
            'cms:content:create',
            PagesController::class,
            'create'
        );
        $this->addRoute(
            'pages/{id}/addchild/{typeId}',
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
            'pages/{id}/edit/{locale}/{clone?}',
            'cms:pages:edit_locale',
            PagesController::class,
            'editLocale'
        );
        $this->addRoute(
            'pages/{id}/edit/{locale}',
            'cms:pages:update',
            PagesController::class,
            'update',
            Request::METHOD_POST
        );
        $this->addRoute(
            'pages/{entity}/revisions',
            'cms:pages:revisions',
            PagesController::class,
            'revisions'
        );
        $this->addRoute(
            'pages/{id}/create_locale',
            'cms:pages:create_locale',
            PagesController::class,
            'createLocale',
            Request::METHOD_POST
        );
        $this->addRoute(
            'pages/{id}',
            'cms:pages:delete',
            PagesController::class,
            'delete',
            Request::METHOD_DELETE
        );
        $this->addRoute(
            'pages/{id}/update_parent/{parentId}',
            'cms:pages:update_parent',
            PagesController::class,
            'updateParent',
            Request::METHOD_POST
        );


        // Blocks
        $this->addRoute(
            'blocks',
            'cms:blocks:manage',
            BlocksController::class,
            'manage'
        );
        $this->addRoute(
            'blocks/{typeId}',
            'cms:blocks:create',
            BlocksController::class,
            'create'
        );
        $this->addRoute(
            'typeId/{id}',
            'cms:blocks:save',
            BlocksController::class,
            'save',
            Request::METHOD_POST
        );
        $this->addRoute(
            'blocks/{id}/edit',
            'cms:blocks:edit',
            BlocksController::class,
            'edit'
        );
        $this->addRoute(
            'blocks/{id}/edit/{locale}',
            'cms:blocks:edit_locale',
            BlocksController::class,
            'editLocale'
        );
        $this->addRoute(
            'blocks/{id}/edit/{locale}',
            'cms:blocks:update',
            BlocksController::class,
            'update',
            Request::METHOD_POST
        );
        $this->addRoute(
            'blocks/{id}/create_locale',
            'cms:blocks:create_locale',
            BlocksController::class,
            'createLocale',
            Request::METHOD_POST
        );
        $this->addRoute(
            'blocks/{id}/delete',
            'cms:blocks:delete',
            BlocksController::class,
            'delete'
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

        $this->addRoute(
            'types/{typeId}/fields/{fieldId}/delete',
            'cms:types:fields:delete',
            EntityTypeController::class,
            'deleteField'
        );


        // Select field options
        $this->addRoute(
            'types/{typeId}/fields/{fieldId}/options/create',
            'cms:types:fields:options:create',
            EntityTypeController::class,
            'createOption'
        );

        $this->addRoute(
            'types/{typeId}/fields/{fieldId}/options/save',
            'cms:types:fields:options:save',
            EntityTypeController::class,
            'saveOption',
            Request::METHOD_POST
        );

        $this->addRoute(
            'types/{typeId}/fields/{fieldId}/options/{optionId}/edit',
            'cms:types:fields:options:edit',
            EntityTypeController::class,
            'editOption'
        );

        $this->addRoute(
            'types/{typeId}/fields/{fieldId}/options/{optionId}/edit',
            'cms:types:fields:options:update',
            EntityTypeController::class,
            'updateOption',
            Request::METHOD_POST
        );

        $this->addRoute(
            'types/{typeId}/fields/{fieldId}/options/{optionId}/delete',
            'cms:types:fields:options:delete',
            EntityTypeController::class,
            'deleteOption'
        );


        // Groups
        $this->addRoute(
            'types/{typeId}/groups',
            'cms:types:groups',
            EntityTypeController::class,
            'groupsManage'
        );

        $this->addRoute(
            'types/{typeId}/groups',
            'cms:types:groups',
            EntityTypeController::class,
            'saveGroups',
            Request::METHOD_POST
        );

        $this->addRoute(
            'types/{typeId}/groups/create',
            'cms:types:groups:create',
            EntityTypeController::class,
            'createGroup'
        );

        $this->addRoute(
            'types/{typeId}/groups/create',
            'cms:types:groups:save',
            EntityTypeController::class,
            'saveGroup',
            Request::METHOD_POST
        );

        $this->addRoute(
            'types/{typeId}/groups/{groupId}/edit',
            'cms:types:groups:edit',
            EntityTypeController::class,
            'editGroup'
        );

        $this->addRoute(
            'types/{typeId}/groups/{groupId}/edit',
            'cms:types:groups:update',
            EntityTypeController::class,
            'updateGroup',
            Request::METHOD_POST
        );

        $this->addRoute(
            'types/{typeId}/groups/{groupId}/delete',
            'cms:types:groups:delete',
            EntityTypeController::class,
            'deleteGroup'
        );

        // Combo
        $this->addRoute(
            'types/{typeId}/combos/add',
            'cms:types:combos:add',
            EntityTypeController::class,
            'addCombo'
        );

        $this->addRoute(
            'types/{typeId}/combos/add',
            'cms:types:combos:save',
            EntityTypeController::class,
            'saveCombo',
            Request::METHOD_POST
        );

        $this->addRoute(
            'types/{typeId}/combos/{comboId}/edit',
            'cms:types:combos:edit',
            EntityTypeController::class,
            'editCombo'
        );

        $this->addRoute(
            'types/{typeId}/combos/{comboId}/edit',
            'cms:types:combos:update',
            EntityTypeController::class,
            'updateCombo',
            Request::METHOD_POST
        );

        $this->addRoute(
            'types/{typeId}/combos/{comboId}/delete',
            'cms:types:combos:delete',
            EntityTypeController::class,
            'deleteCombo'
        );

        // Combo (sub)Fields
        $this->addRoute(
            'types/{typeId}/combos/{comboId}/field/add',
            'cms:types:combos:fields:add',
            EntityTypeController::class,
            'addComboField'
        );

        $this->addRoute(
            'types/{typeId}/combos/{comboId}/field/add',
            'cms:types:combos:fields:save',
            EntityTypeController::class,
            'saveComboField',
            Request::METHOD_POST
        );

        $this->addRoute(
            'types/{typeId}/combos/{comboId}/field/{fieldId}/edit',
            'cms:types:combos:fields:edit',
            EntityTypeController::class,
            'editComboField'
        );

        $this->addRoute(
            'types/{typeId}/combos/{comboId}/field/{fieldId}/edit',
            'cms:types:combos:fields:update',
            EntityTypeController::class,
            'updateComboField',
            Request::METHOD_POST
        );

        $this->addRoute(
            'types/{typeId}/combos/{comboId}/field/{fieldId}/delete',
            'cms:types:combos:fields:delete',
            EntityTypeController::class,
            'deleteComboField'
        );

        // Select field options
        $this->addRoute(
            'types/{typeId}/combos/{comboId}/fields/{fieldId}/options/create',
            'cms:types:combos:fields:options:create',
            EntityTypeController::class,
            'createComboOption'
        );

        $this->addRoute(
            'types/{typeId}/combos/{comboId}/fields/{fieldId}/options/save',
            'cms:types:combos:fields:options:save',
            EntityTypeController::class,
            'saveComboOption',
            Request::METHOD_POST
        );

        $this->addRoute(
            'types/{typeId}/combos/{comboId}/fields/{fieldId}/options/{optionId}/edit',
            'cms:types:combos:fields:options:edit',
            EntityTypeController::class,
            'editComboOption'
        );

        $this->addRoute(
            'types/{typeId}/combos/{comboId}/fields/{fieldId}/options/{optionId}/edit',
            'cms:types:combos:fields:options:update',
            EntityTypeController::class,
            'updateComboOption',
            Request::METHOD_POST
        );

        $this->addRoute(
            'types/{typeId}/combos/{comboId}/fields/{fieldId}/options/{optionId}/delete',
            'cms:types:combos:fields:options:delete',
            EntityTypeController::class,
            'deleteComboOption'
        );

        $this->addRoute(
            'clone/{field}',
            'cms:clone:field',
            EntityTypeController::class,
            'cloneField',
            Request::METHOD_POST
        );

        $this->addRoute(
            'sitemap.xml',
            'cms:sitemap:xml',
            SitemapController::class,
            'xml',
            Request::METHOD_GET,
            false
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

        $this->publishes([
            __DIR__ . '/Commands' => app_path('Console/Commands'),
        ], 'commands');

        $this->pluginManager->registerNavLink('Content', route('cms:pages:manage'), 'cms:content:manage');
        $this->pluginManager->registerNavLink('Blocks', route('cms:blocks:manage'), 'cms:content:manage');
//        $this->pluginManager->registerNavLink('Collections', route('cms:pages:manage'), 'cms:content:manage');
        $this->pluginManager->registerNavLink('Content Types', route('cms:types:manage'), 'cms:entity:type:manage');

        $this->fieldTypesManager->registerFieldType(new TextFieldType());
        $this->fieldTypesManager->registerFieldType(new FileFieldType());
        $this->fieldTypesManager->registerFieldType(new BooleanFieldType());
        $this->fieldTypesManager->registerFieldType(new WysiwygFieldType());
        $this->fieldTypesManager->registerFieldType(new ComboFieldType());
        $this->fieldTypesManager->registerFieldType(new SelectFieldType());
        $this->fieldTypesManager->registerFieldType(new DatetimeFieldType());
        $this->fieldTypesManager->registerFieldType(new ImageFieldType());
//        $this->fieldTypesManager->registerFieldType(new VideoFieldType());
        $this->fieldTypesManager->registerFieldType(new ItemFieldType());
//        $this->fieldTypesManager->registerFieldType(new ColourpickerFieldType());
        $this->fieldTypesManager->registerFieldType(new LocationFieldType());
//        $this->fieldTypesManager->registerFieldType(new UserFieldType());
    }
}
