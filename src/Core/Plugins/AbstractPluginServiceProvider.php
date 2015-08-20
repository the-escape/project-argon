<?php

namespace Escape\Argon\Core\Plugins;

use Illuminate\Support\ServiceProvider;
use Route;

abstract class AbstractPluginServiceProvider extends ServiceProvider
{
    protected $name = '';

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

    public function getName()
    {
        if ($this->name == '') {
            throw new \Exception('Plugin name has not been set.');
        }

        return $this->name;
    }

    abstract public function registerPlugin(PluginManager $manager);
}
