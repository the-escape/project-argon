<?php
namespace Escape\Argon\Events;

use Escape\Argon\Authentication\User;
use Illuminate\Http\Request;
use Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class BeforeUserDelete extends Event
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, Request $request, $errors = [])
    {
        $this->user = $user;
        $this->request = $request;
        $this->errors = $errors;
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
