<?php

namespace Escape\Argon\Table;

use Illuminate\Support\ServiceProvider;

class TableServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }

    public function register()
    {
        $this->loadViewsFrom(__DIR__.'/resources/views/', 'argon.table');
    }
}
