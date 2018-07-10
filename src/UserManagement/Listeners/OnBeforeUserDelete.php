<?php

namespace App\Listeners;

use Escape\Argon\Events\BeforeUserDelete;

class OnBeforeUserDelete
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  BeforeUserDelete  $event
     * @return void
     */
    public function handle(BeforeUserDelete $event)
    {
        //

        return;
    }
}