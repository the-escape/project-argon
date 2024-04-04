<?php

namespace Escape\Argon\Events;

use Escape\Argon\EntityManagement\Eloquent\Entity;
use Escape\Argon\EntityManagement\Eloquent\EntityGroup;
use Escape\Argon\EntityManagement\Eloquent\Localisation;
use Escape\Argon\EntityManagement\FieldTypes\AbstractFieldType;
use Escape\Argon\EntityManagement\FieldValues\AbstractFieldValue;
use Event;
use Illuminate\Queue\SerializesModels;

class RenderField extends Event
{
    use SerializesModels;

    private $fieldType;

    private $fieldValue;

    private $group;

    private $entity;

    private $localisation;

    /**
     * Create a new event instance.
     *
     * @return void
     *
     * @param AbstractFieldType $fieldType
     * @param null|AbstractFieldValue $fieldValue
     * @param EntityGroup $group
     * @param Entity $entity
     * @param Localisation $localisation
     */
    public function __construct(AbstractFieldType $fieldType, AbstractFieldValue $fieldValue = null, EntityGroup $group, Entity $entity, Localisation $localisation)
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
