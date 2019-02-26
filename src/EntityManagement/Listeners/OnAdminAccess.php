<?php

namespace App\Listeners;

use Escape\Argon\Events\AdminAccess;

class OnAdminAccess
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
     * @param  AdminAccess  $event
     * @return void
     */
    public function handle(AdminAccess $event)
    {
        // $event->middleware = [];
        // $event->middleware[] = 'admin.redirects';

        return $event;
    }
}