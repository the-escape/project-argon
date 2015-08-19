<?php

namespace Escape\Argon\Tests;

use Escape\Argon\Core\ArgonServiceProvider;
use Escape\Argon\Tests\LaravelStubs\LaravelApplication;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\TestCase as LaravelTestCase;

class TestCase extends LaravelTestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        /** @var Application $app */
        $app = new LaravelApplication(
            realpath(__DIR__.'/../../vendor/laravel/laravel')
        );

        $app->singleton(
            \Illuminate\Contracts\Http\Kernel::class,
            \Illuminate\Foundation\Http\Kernel::class
        );

        $app->singleton(
            \Illuminate\Contracts\Console\Kernel::class,
            \Escape\Argon\Tests\LaravelStubs\ConsoleKernel::class
        );

        $app->singleton(
            \Illuminate\Contracts\Debug\ExceptionHandler::class,
            \Illuminate\Foundation\Exceptions\Handler::class
        );

        $app->make(Kernel::class)->bootstrap();

        $app->register(ArgonServiceProvider::class);

        config(['database.connections.sqlite.database' => ':memory:']);

        $app->singleton('Illuminate\Database\Eloquent\Factory', function ($app) {
            return Factory::construct($app['Faker\Generator'], __DIR__ . '/../Factories');
        });

        return $app;
    }
}
