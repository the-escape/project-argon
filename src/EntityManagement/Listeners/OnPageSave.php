<?php

namespace App\Listeners;

use Escape\Argon\Events\PageSaved;

class OnPageSave
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
     * @param  PageSaved  $event
     * @return void
     */
    public function handle(PageSaved $event)
    {
        //

        return;
    }
}