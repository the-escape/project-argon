<?php

namespace Escape\Argon\Media;

use Escape\Argon\Core\Plugins\AbstractPluginServiceProvider;
use Escape\Argon\Media\Http\Controllers\MediaController;
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
            'index'
        );

        $this->addRoute(
            'media/folders',
            'cms:media:folders',
            MediaController::class,
            'folders'
        );

        $this->addRoute(
            'media/items',
            'cms:media:items',
            MediaController::class,
            'items'
        );


        $this->addRoute(
            'media/upload',
            'cms:media:upload',
            MediaController::class,
            'upload',
            Request::METHOD_POST
        );
        /*
        $this->addRoute(
            'media/items',
            'cms:media:items',
            MediaController::class,
            'items'
        );
        */
        $this->addRoute(
            'media/items/{itemId}',
            'cms:media:items:details',
            MediaController::class,
            'itemDetails'
        );
        $this->addRoute(
            'media/items/{itemId}',
            'cms:media:items:delete',
            MediaController::class,
            'deleteItem',
            Request::METHOD_DELETE
        );
        $this->addRoute(
            'media/folders',
            'cms:media:folders:create',
            MediaController::class,
            'createFolder',
            Request::METHOD_POST
        );
        $this->addRoute(
            'media/folders/{folderId}',
            'cms:media:folders:delete',
            MediaController::class,
            'deleteFolder',
            Request::METHOD_DELETE
        );
        $this->addRoute(
            'media/browser',
            'cms:media:browse',
            MediaController::class,
            'browse'
        );
    }

    public function startup()
    {
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'argon.media');

        $this->pluginManager->registerNavLink('Media Library', route('cms:media:manage'), 'cms:content:manage');

        $this->publishes([
            __DIR__ . '/Migrations' => database_path('migrations'),
        ], 'migrations');
    }
}
