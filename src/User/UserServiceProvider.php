<?php

namespace Escape\Argon\User;

use Escape\Argon\Core\Plugins\AbstractPluginServiceProvider;
use Escape\Argon\User\Http\Controllers\RoleController;
use Escape\Argon\User\Http\Controllers\UserController;

use Illuminate\Http\Request;

class UserServiceProvider extends AbstractPluginServiceProvider
{
    protected $name = 'User Management';

    public function registerRoutes()
    {
        $this->addRoute(
            'users',
            'cms:user:manage',
            UserController::class,
            'index'
        );
        $this->addRoute(
            'users/create',
            'cms:user:create',
            UserController::class,
            'create'
        );
        $this->addRoute(
            'users/create',
            'cms:user:save',
            UserController::class,
            'save',
            Request::METHOD_POST
        );
        $this->addRoute(
            'users/profile',
            'cms:user:profile',
            UserController::class,
            'profile'
        );
        $this->addRoute(
            'users/{userId}/edit',
            'cms:user:edit',
            UserController::class,
            'edit'
        );
        $this->addRoute(
            'users/{userId}/edit',
            'cms:user:update',
            UserController::class,
            'update',
            Request::METHOD_POST
        );
        $this->addRoute(
            'users/{userId}/delete',
            'cms:user:delete',
            UserController::class,
            'delete'
        );

        // Roles
        $this->addRoute(
            'roles',
            'cms:role:manage',
            RoleController::class,
            'index'
        );
        $this->addRoute(
            'roles/create',
            'cms:role:create',
            RoleController::class,
            'create'
        );
        $this->addRoute(
            'roles/create',
            'cms:role:save',
            RoleController::class,
            'save',
            Request::METHOD_POST
        );
        $this->addRoute(
            'roles/{roleId}/edit',
            'cms:role:edit',
            RoleController::class,
            'edit'
        );
        $this->addRoute(
            'roles/{roleId}/edit',
            'cms:role:update',
            RoleController::class,
            'update',
            Request::METHOD_POST
        );
        $this->addRoute(
            'roles/{roleId}/delete',
            'cms:role:delete',
            RoleController::class,
            'delete'
        );
    }

    public function startup()
    {
        $this->pluginManager->registerNavLink('Users', route('cms:user:manage'), 'cms:user:manage');
        $this->pluginManager->registerNavLink('Roles', route('cms:role:manage'), 'cms:role:manage');

        $this->loadViewsFrom(__DIR__ . '/resources/views', 'argon.user');

        $this->permissionsManager->register('cms:user:manage');
        $this->permissionsManager->register('cms:role:manage');

        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'argon.user');
    }
}
