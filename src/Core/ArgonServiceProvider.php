<?php

namespace Escape\Argon\Core;

use Escape\Argon\Authentication\AuthenticationServiceProvider;
use Escape\Argon\Core\Http\Request;
use Escape\Argon\Core\Plugins\PluginServiceProvider;
use Escape\Argon\EntityManagement\EntityManagementServiceProvider;
use Escape\Argon\Locales\LocalesServiceProvider;
use Escape\Argon\Media\MediaServiceProvider;
use Escape\Argon\Menus\MenusServiceProvider;
use Escape\Argon\RedirectManagement\RedirectManagementServiceProvider;
use Escape\Argon\UserManagement\UserManagementServiceProvider;
use Illuminate\Support\ServiceProvider;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageServiceProvider;
use Prettus\Repository\Providers\RepositoryServiceProvider;
use Maknz\Slack\Laravel\ServiceProvider as SlackServiceProvider;
use Maknz\Slack\Facades\Slack;
use Illuminate\Foundation\AliasLoader;

class ArgonServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if (!$this->app->routesAreCached()) {
            require __DIR__ . '/../../routes.php';
        }

        $this->loadViewsFrom(__DIR__ . '/../../views', 'argon');

        $this->publishes([
            __DIR__.'/../../public' => public_path('argon'),
        ], 'public');

        $this->publishes([
            __DIR__.'/../../migrations' => database_path('migrations'),
        ], 'migrations');

        $this->publishes([
            __DIR__.'/../../config/argon.php' => config_path('argon.php'),
            __DIR__.'/../../config/solr.php' => config_path('solr.php'),
            __DIR__.'/../../config/slack.php' => config_path('slack.php'),
        ], 'config');

    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/argon.php', 'argon');
        $this->mergeConfigFrom(__DIR__ . '/../../config/solr.php', 'solr');
        $this->mergeConfigFrom(__DIR__ . '/../../config/slack.php', 'slack');

        $this->app->alias('request', Request::class);

        $this->app->register(RepositoryServiceProvider::class);

        $this->app->register(AuthenticationServiceProvider::class);

        $this->app->register(PluginServiceProvider::class);

        $this->app->register(EntityManagementServiceProvider::class);

        $this->app->register(UserManagementServiceProvider::class);

        $this->app->register(LocalesServiceProvider::class);

        $this->app->register(ImageServiceProvider::class);
        class_alias(Image::class, 'Image');

        $this->app->register(MediaServiceProvider::class);

        $this->app->register(RedirectManagementServiceProvider::class);

        $this->app->register(MenusServiceProvider::class);

        $this->app->register(SlackServiceProvider::class);

        // this is how we load the facade in the service provider
        $loader = AliasLoader::getInstance();
        $loader->alias('Slack', 'Maknz\Slack\Laravel\Facade');
    }
}
