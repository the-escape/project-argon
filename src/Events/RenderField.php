<?php
namespace Escape\Argon\Events;


use Escape\Argon\EntityManagement\Eloquent\Entity;
use Escape\Argon\EntityManagement\Eloquent\EntityGroup;
use Escape\Argon\EntityManagement\Eloquent\Localisation;
use Escape\Argon\EntityManagement\FieldTypes\AbstractFieldType;
use Escape\Argon\EntityManagement\FieldValues\AbstractFieldValue;
use Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class RenderField extends Event
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(AbstractFieldType $fieldType, AbstractFieldValue $fieldValue=null, EntityGroup $group, Entity $entity, Localisation $localisation)
    {
        $this->fieldType = $fieldType;
        $this->fieldValue = $fieldValue;
        $this->group = $group;
        $this->entity = $entity;
        $this->localisation = $localisation;
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
