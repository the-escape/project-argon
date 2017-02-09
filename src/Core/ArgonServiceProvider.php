<?php

namespace Escape\Argon\Core;

use Escape\Argon\Auth\AuthServiceProvider;
use Escape\Argon\Core\Http\Requests\Request;
use Escape\Argon\Core\Plugins\PluginServiceProvider;
use Escape\Argon\Dashboard\DashboardServiceProvider;
use Escape\Argon\Entity\EntityServiceProvider;
use Escape\Argon\Locale\LocaleServiceProvider;
use Escape\Argon\Media\MediaServiceProvider;
use Escape\Argon\Table\TableServiceProvider;
use Escape\Argon\User\UserServiceProvider;
use Escape\Argon\Redirect\RedirectServiceProvider;

use Illuminate\Support\ServiceProvider;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageServiceProvider;
use Prettus\Repository\Providers\RepositoryServiceProvider;

class ArgonServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (!$this->app->routesAreCached()) {
            require __DIR__ . '/Http/routes.php';
        }

        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'argon');

        $this->publishes([
            __DIR__.'/../../public' => public_path('argon/assets'),
        ], 'public');

        $this->publishes([
            __DIR__ . '/../../database/migrations' => database_path('migrations'),
        ], 'migrations');

        $this->publishes([
            __DIR__.'/../../config/argon.php' => config_path('argon.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../../config/solr.php' => config_path('solr.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/argon.php', 'argon');
        $this->mergeConfigFrom(__DIR__ . '/../../config/solr.php', 'solr');

        $this->app->alias('request', Request::class);
        $this->app->alias('Image', Image::class);

        $this->app->register(RepositoryServiceProvider::class);
        $this->app->register(PluginServiceProvider::class);
        $this->app->register(AuthServiceProvider::class);
        $this->app->register(EntityServiceProvider::class);
        $this->app->register(UserServiceProvider::class);
        $this->app->register(LocaleServiceProvider::class);
        $this->app->register(ImageServiceProvider::class);
        $this->app->register(MediaServiceProvider::class);
        $this->app->register(TableServiceProvider::class);
        $this->app->register(DashboardServiceProvider::class);
        $this->app->register(RedirectServiceProvider::class);

        $this->loadViewsFrom(__DIR__.'/resources/views', 'argon');
    }
}
