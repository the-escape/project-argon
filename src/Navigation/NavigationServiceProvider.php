<?php

namespace Escape\Argon\Navigation;

use Escape\Argon\Core\Plugins\AbstractPluginServiceProvider;
use Escape\Argon\Navigation\Controllers\NavigationController;
use Illuminate\Http\Request;

class NavigationServiceProvider extends AbstractPluginServiceProvider
{
    protected $name = 'Navigation';

    protected function registerRoutes()
    {
        $this->addRoute('navigation', 'cms:navigation:manage', NavigationController::class, 'manage', Request::METHOD_GET);
        $this->addRoute('/navigation/save', 'cms:navigation:save', NavigationController::class, 'save', Request::METHOD_POST);
    }

//    public function boot()
//    {
//        parent::boot();
//    }

    public function startup()
    {
        $this->permissionsManager->register('cms:navigation:manage');
        $this->pluginManager->registerNavLink('Navigation', route('cms:navigation:manage'), 'cms:navigation:manage');
        $this->loadViewsFrom(__DIR__ . '/Views', 'argon_navigation');
        $this->loadTranslationsFrom(__DIR__ . '/lang', 'argon-navigation');
    }
}
