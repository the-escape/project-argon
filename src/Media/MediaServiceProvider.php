<?php

namespace Escape\Argon\Media;

use Escape\Argon\Core\Plugins\AbstractPluginServiceProvider;
use Escape\Argon\Media\Controllers\MediaController;
use Illuminate\Http\Request;

class MediaServiceProvider extends AbstractPluginServiceProvider
{
    protected $name = 'Media';

    public function registerRoutes()
    {
	$this->addRoute(
	    'media',
	    'cms:media:manage',
	    MediaController::class,
	    'manage'
	);
	$this->addRoute(
	    'media/upload',
	    'cms:media:upload',
	    MediaController::class,
	    'upload',
	    Request::METHOD_POST
	);
	$this->addRoute(
	    'media/items',
	    'cms:media:items',
	    MediaController::class,
	    'items'
	);
//        $this->addRoute(
//            'locales/{localeId}/edit',
//            'cms:locales:edit',
//            LocalesController::class,
//            'edit'
//        );
//        $this->addRoute(
//            'locales/{localeId}/edit',
//            'cms:locales:edit',
//            LocalesController::class,
//            'update',
//            Request::METHOD_POST
//        );
//        $this->addRoute(
//            'locales/{localeId}/delete',
//            'cms:locales:delete',
//            LocalesController::class,
//            'delete'
//        );
//        $this->addRoute(
//            'locales/set/{localeId}',
//            'cms:locales:set',
//            LocalesController::class,
//            'set'
//        );
    }

    public function startup()
    {
	$this->loadViewsFrom(__DIR__ . '/Views', 'argon');

	$this->pluginManager->registerNavLink('Media', route('cms:media:manage'), 'cms:content:manage');

	$this->publishes([
	    __DIR__ . '/Migrations' => database_path('migrations'),
	], 'migrations');
    }
}
