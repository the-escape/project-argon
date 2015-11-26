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
    protected $fillable = ['name', 'field_type', 'entity_type_id', 'settings', 'entity_group_id', 'parent_field_id'];

    public function group()
    {
        return $this->belongsTo(EntityGroup::class, 'entity_group_id');
    }

    /**
     * @return AbstractFieldType
     */
    public function getTypeAttribute()
    {
        return app('fieldTypes')->getType($this->field_type);
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
