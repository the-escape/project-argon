<?php

namespace Escape\Argon\Menus;

use Escape\Argon\Core\Plugins\AbstractPluginServiceProvider;
use Escape\Argon\Menus\Controllers\MenusController;
use Illuminate\Http\Request;

class MenusServiceProvider extends AbstractPluginServiceProvider
{
    protected $name = 'Menus';

    protected function registerRoutes()
    {
        $this->addRoute(
            'menus',
            'cms:menus:manage',
            MenusController::class,
            'manage'
        );
        /* leaving this here for the time being just in case something's not right with vue component, sorry */
        // $this->addRoute(
        //     'menus/create',
        //     'cms:menus:create',
        //     MenusController::class,
        //     'create'
        // );
        $this->addRoute(
            'menus/create',
            'cms:menus:create',
            MenusController::class,
            'createNew'
        );
        $this->addRoute(
            'menus/create',
            'cms:menus:save',
            MenusController::class,
            'save',
            Request::METHOD_POST
        );
        /* leaving this here for the time being just in case something's not right with vue component, sorry */
        // $this->addRoute(
        //     'menus/{id}/edit',
        //     'cms:menus:edit',
        //     MenusController::class,
        //     'edit'
        // );
        $this->addRoute(
            'menus/{id}/edit',
            'cms:menus:edit',
            MenusController::class,
            'editNew'
        );
        $this->addRoute(
            'menus/{id}/edit',
            'cms:menus:update',
            MenusController::class,
            'update',
            Request::METHOD_POST
        );
        $this->addRoute(
            'menus/{id}/delete',
            'cms:menus:delete',
            MenusController::class,
            'delete'
        );
    }

    public function boot()
    {
        parent::boot();
    }

    public function startup()
    {
        $this->permissionsManager->register('cms:menus:manage');
        $this->pluginManager->registerNavLink('Menus', route('cms:menus:manage'), 'cms:menus:manage', 'menu');
        $this->loadViewsFrom(__DIR__ . '/Views', 'argon_menus');
        $this->loadTranslationsFrom(__DIR__ . '/lang', 'argon-menus');

        $this->publishes([
            __DIR__ . '/Migrations' => database_path('migrations'),
        ], 'migrations');
    }
}
