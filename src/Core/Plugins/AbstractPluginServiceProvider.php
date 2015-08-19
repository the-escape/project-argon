<?php

namespace Escape\Argon\Core\Plugins;

use Illuminate\Support\ServiceProvider;
use Route;

abstract class AbstractPluginServiceProvider extends ServiceProvider
{
    public function addRoute($path, $definition, $methods = 'GET')
    {
        if (is_string($methods)) {
            $methods = [$methods];
        }

        $prefix = config('argon.admin_route_prefix');
        $prefix = rtrim($prefix, "/") . '/';
        foreach ($methods as $method) {
            switch (strtoupper($method)) {
                case 'GET':
                    Route::get($prefix . $path, $definition);
                    break;
                case 'POST':
                    Route::post($prefix . $path, $definition);
                    break;
            }

        }
    }
}