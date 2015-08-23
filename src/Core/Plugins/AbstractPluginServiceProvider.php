<?php

namespace Escape\Argon\Core\Plugins;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Route;

abstract class AbstractPluginServiceProvider extends ServiceProvider
{
    protected $name = '';

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
}
