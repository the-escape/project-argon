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
}
