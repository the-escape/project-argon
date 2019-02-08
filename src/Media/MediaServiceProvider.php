<?php

namespace Escape\Argon\Media;

use Escape\Argon\Core\Plugins\AbstractPluginServiceProvider;
use Escape\Argon\Media\Controllers\MediaController;
use Escape\Argon\Media\Helpers\ImageOptim;
use Illuminate\Http\Request;

class MediaServiceProvider extends AbstractPluginServiceProvider
{
    protected $name = 'Media';

    public function registerRoutes()
    {
        $this->addRoute(
            'media/app',
            'cms:media:app',
            MediaController::class,
            'app'
        );
        $this->addRoute(
            'media/api/folders/add',
            'cms:media:api:folders:add',
            MediaController::class,
            'appFolderAdd',
            Request::METHOD_POST
        );
        $this->addRoute(
            'media/api/folders/edit',
            'cms:media:api:folders:edit',
            MediaController::class,
            'appFolderEdit',
            Request::METHOD_POST
        );
        $this->addRoute(
            'media/api/folders/remove',
            'cms:media:api:folders:remove',
            MediaController::class,
            'appFolderRemove',
            Request::METHOD_POST
        );
        $this->addRoute(
            'media/api/folders/{id?}',
            'cms:media:api:folders',
            MediaController::class,
            'appFolders'
        );
        $this->addRoute(
            'media/api/search/{keywords?}',
            'cms:media:api:search',
            MediaController::class,
            'appSearch'
        );
        $this->addRoute(
            'media/api/upload',
            'cms:media:api:upload',
            MediaController::class,
            'appUpload',
            Request::METHOD_POST
        );
        $this->addRoute(
            'media/api/items/remove',
            'cms:media:api:items:remove',
            MediaController::class,
            'appDeleteItem',
            Request::METHOD_POST
        );
        $this->addRoute(
            'media/api/items/move',
            'cms:media:api:items:move',
            MediaController::class,
            'appMoveItem',
            Request::METHOD_POST
        );
        $this->addRoute(
            'media/api/items/move-multi',
            'cms:media:api:items:move-multi',
            MediaController::class,
            'appMoveItems',
            Request::METHOD_POST
        );
        $this->addRoute(
            'media/api/delete',
            'cms:media:api:delete',
            MediaController::class,
            'appDelete',
            Request::METHOD_POST
        );
        $this->addRoute(
            'media/api/recent',
            'cms:media:api:recent',
            MediaController::class,
            'appRecent'
        );









        /* below routes are for the legacy media library */

        $this->addRoute(
            'media',
            'cms:media:manage',
            MediaController::class,
//            'manage'
            'all'
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
//        $this->addRoute(
//            'locales/set/{localeId}',
//            'cms:locales:set',
//            LocalesController::class,
//            'set'
//        );
        $this->addRoute(
            'media/browser',
            'cms:media:browse',
            MediaController::class,
            'browse'
        );



        $this->addRoute(
            'media/modal/all',
            'cms:media:modal:all',
            MediaController::class,
            'modalAll',
            Request::METHOD_GET
        );
        $this->addRoute(
            'media/all',
            'cms:media:all',
            MediaController::class,
            'all',
            Request::METHOD_GET
        );

        $this->addRoute(
            'media/edit/{id}',
            'cms:media:edit',
            MediaController::class,
            'edit',
            Request::METHOD_GET
        );

        $this->addRoute(
            'media/modal/edit/{id}',
            'cms:media:modal:edit',
            MediaController::class,
            'modal_edit',
            Request::METHOD_GET
        );

        $this->addRoute(
            'media/update/{id}',
            'cms:media:update',
            MediaController::class,
            'update',
            Request::METHOD_PUT
        );

        $this->addRoute(
            'media/modal/update/{id}',
            'cms:media:modal:update',
            MediaController::class,
            'modal_update',
            Request::METHOD_PUT
        );

        $this->addRoute(
            'media/delete/{id}',
            'cms:media:delete',
            MediaController::class,
            'delete',
            Request::METHOD_GET
        );

        $this->addRoute(
            'media/modal/delete/{id}',
            'cms:media:modal:delete',
            MediaController::class,
            'modal_delete',
            Request::METHOD_GET
        );

        $this->addRoute(
            'media/search',
            'cms:media:search',
            MediaController::class,
            'search',
            Request::METHOD_GET
        );

        $this->addRoute(
            'media/modal/search',
            'cms:media:modal:search',
            MediaController::class,
            'modal_search',
            Request::METHOD_GET
        );

        $this->addRoute(
            'media/folders',
            'cms:media:folders',
            MediaController::class,
            'folders',
            Request::METHOD_GET
        );

        $this->addRoute(
            'media/modal/folders',
            'cms:media:modal:folders',
            MediaController::class,
            'modalFolders',
            Request::METHOD_GET
        );
        $this->addRoute(
            'media/upload_get',
            'cms:media:upload:get',
            MediaController::class,
            'upload_get',
            Request::METHOD_GET
        );
        $this->addRoute(
            'media/modal/upload_get',
            'cms:media:modal:upload:get',
            MediaController::class,
            'modal_upload_get',
            Request::METHOD_GET
        );
        $this->addRoute(
            'media/upload_post',
            'cms:media:upload:post',
            MediaController::class,
            'upload_post',
            Request::METHOD_POST
        );
        $this->addRoute(
            'media/modal/upload_post',
            'cms:media:modal:upload:post',
            MediaController::class,
            'modal_upload_post',
            Request::METHOD_POST
        );
        $this->addRoute(
            'media/folders/{id}/add',
            'cms:media:folders:add',
            MediaController::class,
            'folderAdd',
            Request::METHOD_GET
        );
        $this->addRoute(
            'media/modal/folders/{id}/add',
            'cms:media:modal:folders:add',
            MediaController::class,
            'modal_folderAdd',
            Request::METHOD_GET
        );
        $this->addRoute(
            'media/folders/save',
            'cms:media:folders:save',
            MediaController::class,
            'folderSave',
            Request::METHOD_POST
        );
        $this->addRoute(
            'media/modal/folders/save',
            'cms:media:modal:folders:save',
            MediaController::class,
            'modal_folderSave',
            Request::METHOD_POST
        );
        $this->addRoute(
            'media/folders/{id}',
            'cms:media:folders:edit',
            MediaController::class,
            'folderEdit',
            Request::METHOD_GET
        );
        $this->addRoute(
            'media/modal/folders/{id}',
            'cms:media:modal:folders:edit',
            MediaController::class,
            'modal_folderEdit',
            Request::METHOD_GET
        );
        $this->addRoute(
            'media/folders/{id}/update',
            'cms:media:folders:update',
            MediaController::class,
            'folderUpdate',
            Request::METHOD_PUT
        );
        $this->addRoute(
            'media/modal/folders/{id}/update',
            'cms:media:modal:folders:update',
            MediaController::class,
            'modal_folderUpdate',
            Request::METHOD_PUT
        );
        $this->addRoute(
            'media/folders/{id}/remove',
            'cms:media:folders:remove',
            MediaController::class,
            'folderRemove',
            [Request::METHOD_GET]
        );
        $this->addRoute(
            'media/modal/folders/{id}/remove',
            'cms:media:modal:folders:remove',
            MediaController::class,
            'modal_folderRemove',
            [Request::METHOD_GET]
        );
        $this->addRoute(
            'media/{itemId}/folderParentUpdate/{parentId}',
            'cms:media:parent:update',
            MediaController::class,
            'folderParentUpdate',
            Request::METHOD_POST
        );
        $this->addRoute(
            'media/{itemId}/itemParentUpdate/{parentId}',
            'cms:media:parent:update',
            MediaController::class,
            'itemParentUpdate',
            Request::METHOD_POST
        );

    }

    public function boot()
    {
        $this->app->singleton('imageOptim', function(){
            return new ImageOptim();
        });

        parent::boot();
    }

    public function startup()
    {
        $this->loadViewsFrom(__DIR__ . '/Views', 'argon');

        $this->pluginManager->registerNavLink('Media Library', route('cms:media:manage'), 'cms:content:manage', 'media');

        $this->publishes([
            __DIR__ . '/Migrations' => database_path('migrations'),
        ], 'migrations');

        $this->publishes([
            __DIR__ . '/Commands' => app_path('Console/Commands'),
        ], 'commands');
    }
}
