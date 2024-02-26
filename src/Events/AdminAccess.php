<?php

namespace Escape\Argon\Events;

use Event;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;

class AdminAccess extends Event
{
    use SerializesModels;

    private $request;

    /**
     * Create a new event instance.
     *
     * @return void
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
