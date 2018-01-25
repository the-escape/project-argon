<?php

namespace Escape\Argon\Navigation;

use Escape\Argon\Core\Plugins\AbstractPluginServiceProvider;
use Escape\Argon\Navigation\Controllers\NavigationController;

class NavigationServiceProvider extends AbstractPluginServiceProvider
{
    protected $name = 'Navigation';

    protected function registerRoutes()
    {
        $this->addRoute('navigation', 'cms:navigation:manage', NavigationController::class, 'manage');
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
