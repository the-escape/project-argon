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

    /** @var AssetsManager */
    protected $assetsManager;

    public function addRoute($path, $name, $controller, $methodName, $verbs = 'GET', $admin = true)
    {
        if (is_string($verbs)) {
            $verbs = [$verbs];
        }

        $prefix = $admin ? config('argon.admin_route_prefix') : null;
        $prefix = rtrim($prefix, "/") . '/';

        $isUniqueRoute = $this->isUniqueRoute($path, $name, $controller, $methodName, $verbs, $prefix);

        if (!$isUniqueRoute) {
            throw new \Exception('Plugin URI duplication for route: '. $name);
        }

        $definition = [
            'as' => $name,
            'uses' => "{$controller}@{$methodName}"
        ];

        foreach ($verbs as $verb) {
            switch (strtoupper($verb)) {
                case Request::METHOD_GET:
                    Route::get($prefix . $path, $definition);
                    break;
                case Request::METHOD_POST:
                    Route::post($prefix . $path, $definition);
                    break;
                case Request::METHOD_PUT:
                    Route::put($prefix . $path, $definition);
                    break;
                case Request::METHOD_DELETE:
                    Route::delete($prefix . $path, $definition);
                    break;
                default:
                    throw new \Exception('Method not implemented');
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

        $this->assetsManager = $this->app['assetsManager'];

        $this->startup();
    }

    abstract public function startup();

    /**
     * Check whether new route is unique by looking at uri and verbs and comparing that with already registered routes.
     * @param string $path new uri that is going to be registered
     * @param $name
     * @param $controller
     * @param $methodName
     * @param array $verbs HTTP request methods
     * @param string $prefix admin area prefix
     * @return bool
     */
    public function isUniqueRoute($path, $name, $controller, $methodName, $verbs, $prefix)
    {
        $routes = Route::getRoutes();

        foreach ($routes as $route)
        {
            if(legacyLv())
            {
                $uri = $route->getPath();
                $methods = $route->getMethods();
            }
            else
            {
                $uri = $route->uri();
                $methods = $route->methods();
            }

            if ($uri == ltrim($prefix.$path, '/'))
            {
                if (count(array_intersect($methods, $verbs)))
                {
                    return false;
                }
            }
        }

        return true;
    }
}
