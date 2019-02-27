<?php

namespace App\Listeners;

use Escape\Argon\Events\RenderPagesListItemActions;

class OnRenderPagesListItemActions
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
     * @param  RenderPagesListItemActions  $event
     * @return void|array
     *
     * Expects the array with url, label and icon or null/void for no actions
     */
    public function handle(RenderPagesListItemActions $event)
    {

    }
}