<?php

namespace Escape\Argon\Entity;

use Escape\Argon\Core\Plugins\AbstractPluginServiceProvider;
use Escape\Argon\Entity\Http\Controllers\AttributeController;
use Escape\Argon\Entity\Http\Controllers\Block\AdminController;
use Escape\Argon\Entity\Http\Controllers\Block\ApiController;
use Escape\Argon\Entity\Http\Controllers\ContentController;
use Escape\Argon\Entity\Http\Controllers\PageController;
use Escape\Argon\Entity\FieldTypes\ComboFieldType;
use Escape\Argon\Entity\FieldTypes\FieldTypesManager;
use Escape\Argon\Entity\FieldTypes\TextFieldType;
use Escape\Argon\Entity\FieldTypes\ImageFieldType;
use Escape\Argon\Entity\FieldTypes\FileFieldType;
use Escape\Argon\Entity\FieldTypes\BooleanFieldType;
use Escape\Argon\Entity\FieldTypes\ItemFieldType;
use Escape\Argon\Entity\FieldTypes\WysiwygFieldType;
use Escape\Argon\Entity\FieldTypes\DatetimeFieldType;
use Escape\Argon\Entity\FieldTypes\LocationFieldType;
use Escape\Argon\Entity\FieldTypes\SelectFieldType;
use Escape\Argon\Entity\Http\Controllers\SeoController;

class EntityServiceProvider extends AbstractPluginServiceProvider
{
    protected $name = 'Content';

    protected function registerRoutes()
    {
        // Pages
        $this->addRoute(
            'pages',
            'cms:pages:manage',
            PageController::class,
            'index'
        );

        $this->addRoute(
            'pages/{entityId}/content/{entityLocalisationId}',
            'cms:pages:content',
            ContentController::class,
            'edit'
        );

        $this->addRoute(
            'pages/{entityId}/publish/{entityLocalisationId}',
            'cms:pages:publish',
            ContentController::class,
            'publish'
        );

        $this->addRoute(
            'pages/{entityId}/attributes/{entityLocalisationId}',
            'cms:pages:attributes',
            AttributeController::class,
            'edit'
        );

        $this->addRoute(
            'pages/{entityId}/seo/{entityLocalisationId}',
            'cms:pages:seo',
            SeoController::class,
            'edit'
        );

        $this->addRoute(
            'pages/{entityId}/block/{entityLocalisationId}/{entityGroupId}',
            'cms:pages:block',
            AdminController::class,
            'edit'
        );

        $this->addRoute(
            'pages/{entityId}/block/{entityLocalisationId}/{entityGroupId}',
            'cms:pages:block:update',
            AdminController::class,
            'update',
            'post'
        );

        $this->addRoute(
            'api/blocks/{entityLocalisationId}',
            'api:blocks',
            ApiController::class,
            'index'
        );

        $this->addRoute(
            'api/blocks/{entityLocalisationId}/add',
            'api:blocks:add',
            ApiController::class,
            'store',
            'post'
        );

        $this->addRoute(
            'api/blocks/{entityLocalisationId}/remove/{entityGroupId}',
            'api:blocks:remove',
            ApiController::class,
            'destroy',
            'delete'
        );

        $this->addRoute(
            'api/entity-group/{entityTypeId}',
            'api:entity-group:index',
            ApiController::class,
            'entityGroups'
        );

        $this->addRoute(
            'pages/search',
            'cms:content:search',
            PageController::class,
            'search',
            'POST'
        );

        $this->addRoute(
            'pages/store',
            'cms:content:store',
            PageController::class,
            'store',
            'POST'
        );

        $this->addRoute(
            'pages/update/{entityId}',
            'cms:content:update',
            ContentController::class,
            'update',
            'POST'
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

        $this->loadViewsFrom(__DIR__.'/resources/views', 'argon.entity');

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

        $this->fieldTypesManager->registerFieldType(new TextFieldType());
        $this->fieldTypesManager->registerFieldType(new FileFieldType());
        $this->fieldTypesManager->registerFieldType(new BooleanFieldType());
        $this->fieldTypesManager->registerFieldType(new WysiwygFieldType());
        $this->fieldTypesManager->registerFieldType(new ComboFieldType());
        $this->fieldTypesManager->registerFieldType(new SelectFieldType());
        $this->fieldTypesManager->registerFieldType(new DatetimeFieldType());
        $this->fieldTypesManager->registerFieldType(new ImageFieldType());
        $this->fieldTypesManager->registerFieldType(new ItemFieldType());
        $this->fieldTypesManager->registerFieldType(new LocationFieldType());
    }
}
