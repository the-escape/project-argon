<?php

namespace App\Listeners;

use Escape\Argon\Events\RenderField;

class OnRenderField
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
     * @param  RenderField  $event
     * @return void
     */
    public function handle(RenderField $event)
    {
        //

        return;
    }
}