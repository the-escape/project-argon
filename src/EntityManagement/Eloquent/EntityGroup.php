<?php

namespace Escape\Argon\EntityManagement\Eloquent;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/*
 * @property int $id
 * @property string $name
 * @property boolean $system
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 */
class EntityGroup extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'order','sortable', 'renderable', 'entity_type_id', 'settings',];

    protected $entity;

    public function fields()
    {
        return $this->hasMany(EntityField::class)->orderBy('entity_group_id')->orderBy('order')->orderBy('name');
    }

    public function getFields()
    {
        $fields = $this->fields->map(
            function (EntityField $f) {
                return $f->type;
            }
        );

        return $fields;
    }

    public function getFieldsWithValues($page, $localisation, $currentRevision)
    {
        $fields = [];

        foreach($this->getFields() as $field)
        {
            $fields[] = $field->getFieldWithValues($this, $page, $localisation, $currentRevision);
        }

        return $fields;

        /*
            @foreach ($group->getFields() as $field)
                <div class="form-group sortable">

                    <?php
                    $fieldValue = $currentRevision->getField($field->getId());
                    $event = event(new Escape\Argon\Events\RenderField($field, $fieldValue, $group, $page, $localisation)); ?>

                    @if(isset($event[0]->fieldHtml))

                        <div class="field-html">

                            {!! $event[0]->fieldHtml !!}

                        </div>

                    @endif

                    {!! $field->render($currentRevision->getField($field->getId())) !!}

                </div>
            @endforeach
        */
    }

    public function setEntity(Entity $entity)
    {
        $this->entity = $entity;
    }

    public function getName()
    {
        return $this->name;
    }

    public function isSortable()
    {
        return (bool)$this->sortable;
    }

    public function isRenderable()
    {
        return (bool)$this->renderable;
    }

    /**
     * Returns array from saved json value
     * @param $value
     * @return array
     */
    public function getSettingsAttribute($value)
    {
        $value = json_decode($value, true);
        if ($value === null)
        {
            return [];
        }
        return $value;
    }

    public function setSettingsAttribute($value)
    {
        $this->attributes['settings'] = json_encode($value);
    }

    public function getSetting($name, $default=null)
    {
        foreach ($this->settings as $k => $v)
        {
            if ($name == $k)
            {
                return $v;
            }
        }
        return $default;

    }

    public function exportJson()
    {
        $fields = $this->fields;

        $excludeGroupAttributes = [
            'id',
            'entity_type_id',
            'order',
            'created_at',
            'updated_at',
            'deleted_at',
            'fields',
        ];

        $excludeFieldAttributes = [
            'id',
            'entity_type_id',
            'entity_group_id',
            'parent_field_id',
            'created_at',
            'updated_at',
            'deleted_at',
        ];

        foreach($this->toArray() as $attrKey => $attrValue)
        {
            if (!in_array($attrKey, $excludeGroupAttributes))
            {
                $result[$attrKey] = $attrValue;

                if($attrKey == 'settings' && !is_array($attrValue))
                {
                    $result[$attrKey] = json_decode($attrValue,true);
                }
            }
        }

        foreach($fields as $key => $field)
        {
            foreach($field->toArray() as $fieldAttrKey => $fieldAttrValue)
            {
                if (!in_array($fieldAttrKey, $excludeFieldAttributes))
                {
                    $result['fields'][$key][$fieldAttrKey] = $fieldAttrValue;
                }
            }

            if ($field->field_type === 'combo')
            {
                $subFields = $field->subfields;

                foreach($subFields as $subKey => $subField)
                {
                    foreach ($subField->toArray() as $subFieldAttrKey => $subFieldAttrValue)
                    {
                        if (!in_array($subFieldAttrKey, $excludeFieldAttributes))
                        {
                            $result['fields'][$key]['fields'][$subKey][$subFieldAttrKey] = $subFieldAttrValue;
                        }
                    }
                }
            }
        }

        return $result;
    }
}
