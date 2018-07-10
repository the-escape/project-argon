<?php

namespace App\Listeners;

use Escape\Argon\Events\BeforePageSaved;

class OnBeforePageSave
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
     * @param  BeforePageSaved  $event
     * @return void
     */
    public function handle(BeforePageSaved $event)
    {
        //

        return $event;
    }
}