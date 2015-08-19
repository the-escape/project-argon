<?php

namespace Escape\Argon\Tests\LaravelStubs;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Console\Kernel;

class LaravelApplication extends Application
{
    public function databasePath()
    {
        return __DIR__ . '/../../';
    }

}
