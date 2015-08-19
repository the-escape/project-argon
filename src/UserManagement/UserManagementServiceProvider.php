<?php

namespace Escape\Argon\UserManagement;

use Escape\Argon\Authentication\PermissionManager;
use Escape\Argon\Core\Plugins\AbstractPluginServiceProvider;
use Escape\Argon\Core\Plugins\PluginManager;
use Escape\Argon\UserManagement\UserManagementPlugin;
use Illuminate\Http\Request;

class UserManagementServiceProvider extends AbstractPluginServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->addRoute(
            'users',
            ['as' => 'cms:user:manage', 'uses' => 'Escape\\Argon\\UserManagement\\Controllers\\UserController@index']
        );
        $this->addRoute(
            'users/create',
            ['as' => 'cms:user:create', 'uses' => 'Escape\\Argon\\UserManagement\\Controllers\\UserController@create']
        );
        $this->addRoute(
            'users/create',
            ['as' => 'cms:user:save', 'uses' => 'Escape\\Argon\\UserManagement\\Controllers\\UserController@save'],
            Request::METHOD_POST
        );
        $this->addRoute(
            'users/profile',
            ['as' => 'cms:user:profile', 'uses' => 'Escape\\Argon\\UserManagement\\Controllers\\UserController@profile']
        );
        $this->addRoute(
            'users/{userId}/edit',
            ['as' => 'cms:user:edit', 'uses' => 'Escape\\Argon\\UserManagement\\Controllers\\UserController@edit']
        );
        $this->addRoute(
            'users/{userId}/edit',
            ['as' => 'cms:user:update', 'uses' => 'Escape\\Argon\\UserManagement\\Controllers\\UserController@update'],
            Request::METHOD_POST
        );
        $this->addRoute(
            'users/{userId}/delete',
            ['as' => 'cms:user:delete', 'uses' => 'Escape\\Argon\\UserManagement\\Controllers\\UserController@delete']
        );

        // Roles
        $this->addRoute(
            'roles',
            ['as' => 'cms:role:manage', 'uses' => 'Escape\\Argon\\UserManagement\\Controllers\\RoleController@index']
        );
        $this->addRoute(
            'roles/create',
            ['as' => 'cms:role:create', 'uses' => 'Escape\\Argon\\UserManagement\\Controllers\\RoleController@create']
        );
        $this->addRoute(
            'roles/create',
            ['as' => 'cms:role:save', 'uses' => 'Escape\\Argon\\UserManagement\\Controllers\\RoleController@save'],
            Request::METHOD_POST
        );
        $this->addRoute(
            'roles/{roleId}/edit',
            ['as' => 'cms:role:edit', 'uses' => 'Escape\\Argon\\UserManagement\\Controllers\\RoleController@edit']
        );
        $this->addRoute(
            'roles/{roleId}/edit',
            ['as' => 'cms:role:update', 'uses' => 'Escape\\Argon\\UserManagement\\Controllers\\RoleController@update'],
            Request::METHOD_POST
        );
        $this->addRoute(
            'roles/{roleId}/delete',
            ['as' => 'cms:role:delete', 'uses' => 'Escape\\Argon\\UserManagement\\Controllers\\RoleController@delete']
        );
    }

    public function boot()
    {
        /** @var PluginManager $pluginManager */
        $pluginManager = $this->app['pluginManager'];

        $plugin = new UserManagementPlugin();

        $pluginManager->register($plugin);

        $this->loadViewsFrom(__DIR__ . '/views', 'argon');

        /** @var PermissionManager $permissions */
        $permissions = $this->app['permissions'];

        $permissions->register('cms:user:manage');
        $permissions->register('cms:role:manage');

        $this->loadTranslationsFrom(__DIR__ . '/lang', 'argon-users');
    }

}