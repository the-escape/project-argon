<?php
namespace Escape\Argon\Events;

use Escape\Argon\EntityManagement\Eloquent\Entity;
use Event;
use Illuminate\Queue\SerializesModels;

class RenderPagesListItemActions extends Event
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Entity $entity)
    {
        $this->entity = $entity;
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
