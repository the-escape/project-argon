<?php

namespace Escape\Argon\UserManagement;

use Escape\Argon\Authentication\PermissionManager;
use Escape\Argon\Core\Plugins\AbstractPluginServiceProvider;
use Escape\Argon\Core\Plugins\PluginManager;
use Escape\Argon\UserManagement\Controllers\RoleController;
use Escape\Argon\UserManagement\Controllers\UserController;
use Escape\Argon\UserManagement\UserManagementPlugin;
use Illuminate\Http\Request;

class UserManagementServiceProvider extends AbstractPluginServiceProvider
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
        //FrontEnd Routes
        $this->addRoute(
            'api/{data}',
            'api:manage',
            UserAdapter::class,
            "getData"
        );

    }

    public function startup()
    {
        $this->pluginManager->registerNavLink('Users', route('cms:user:manage'), 'cms:user:manage');
        $this->pluginManager->registerNavLink('Roles', route('cms:role:manage'), 'cms:role:manage');

        $this->loadViewsFrom(__DIR__ . '/views', 'argon');

        $this->permissionsManager->register('cms:user:manage');
        $this->permissionsManager->register('cms:role:manage');

        $this->loadTranslationsFrom(__DIR__ . '/lang', 'argon-users');
    }
}
