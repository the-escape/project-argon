<?php

namespace App\Listeners;

use Escape\Argon\Events\UserDelete;

class OnUserDelete
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
     * @param  UserDelete  $event
     * @return void
     */
    public function handle(UserDelete $event)
    {
        //
    }
}