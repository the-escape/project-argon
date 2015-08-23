<?php

namespace Escape\Argon\EntityManagement\Eloquent;

use Escape\Argon\EntityManagement\FieldTypes\AbstractFieldType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class EntityField
 * @package Escape\Argon\EntityManagement
 *
 * @property AbstractFieldType $type
 */
class EntityField extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'field_type', 'entity_type_id', 'settings'];

    /**
     * @return AbstractFieldType
     */
    public function getTypeAttribute()
    {
        return app('fieldTypes')->get($this->field_type);
    }

    public function getSettingsAttribute($value)
    {
        return json_decode($value);
    }

    public function setSettingsAttribute($value)
    {
        $this->attributes['settings'] = json_encode($value);
    }

}
