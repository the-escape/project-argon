<?php

namespace Escape\Argon\Core\Plugins;

use Escape\Argon\Authentication\PermissionManager;
use Escape\Argon\EntityManagement\FieldTypes\FieldTypesManager;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Route;

abstract class AbstractPluginServiceProvider extends ServiceProvider
{
    protected $name = '';

    /** @var PluginManager */
    protected $pluginManager;

    /** @var FieldTypesManager */
    protected $fieldTypesManager;

    /** @var PermissionManger */
    protected $permissionsManager;

    public function addRoute($path, $name, $controller, $methodName, $verbs = 'GET')
    {
        if (is_string($verbs)) {
            $verbs = [$verbs];
        }

        $definition = [
            'as' => $name,
            'uses' => "{$controller}@{$methodName}"
        ];

        $prefix = config('argon.admin_route_prefix');
        $prefix = rtrim($prefix, "/") . '/';
        foreach ($verbs as $verb) {
            switch (strtoupper($verb)) {
                case Request::METHOD_GET:
                    Route::get($prefix . $path, $definition);
                    break;
                case Request::METHOD_POST:
                    Route::post($prefix . $path, $definition);
                    break;
            }

        }
    }

    public function getName()
    {
        if ($this->name == '') {
            throw new \Exception('Plugin name has not been set.');
        }

        return $this->name;
    }

    public function register()
    {
        $this->registerRoutes();
    }

    protected function registerRoutes()
    {
    }

    public function boot()
    {
        /** @var PluginManager $manager */
        $this->pluginManager = $this->app['pluginManager'];
        $this->pluginManager->register($this);

        /** @var FieldTypesManager $fieldTypes */
        $this->fieldTypesManager = $this->app['fieldTypes'];

        /** @var PermissionManager $permissions */
        $this->permissionsManager = $this->app['permissions'];


        $this->startup();
    }

    abstract public function startup();
}
