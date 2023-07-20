<?php
namespace Escape\Argon\Events;

use Escape\Argon\Menus\Eloquent\Menu as Entity;
use Escape\Argon\EntityManagement\Eloquent\Localisation;
use Illuminate\Http\Request;
use Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class MenuSaved extends Event
{
    use SerializesModels;

    private $entity;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Entity $menu)
    {
        $this->entity = $menu;
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

    public function getEntity()
    {
        return $this->entity;
    }
}
