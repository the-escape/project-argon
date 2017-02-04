<?php

namespace Escape\Argon\Entity\Eloquent;

use Escape\Argon\Entity\FieldTypes\AbstractFieldType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class EntityField
 * @package Escape\Argon\Entity
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
    protected $fillable = [
        'name',
        'field_slug',
        'field_type',
        'entity_type_id',
        'settings',
        'entity_group_id',
        'parent_field_id',
        'order'
    ];

    public function group()
    {
        return $this->belongsTo(EntityGroup::class, 'entity_group_id');
    }

    /**
     * @return AbstractFieldType
     */
    public function getTypeAttribute()
    {
        return app('fieldTypes')->getType($this->field_type)->setField($this);
    }

    public function getSettingsAttribute($value)
    {
        $decoded = json_decode($value);
        foreach ($decoded as $name => $value) {
            $property = $this->type->getProperty($name);
            if ($property) {
                switch ($property->type) {
                    case "boolean":
                        $decoded->$name = (boolean)$value;
                        break;
                    case "options":
                        $arr = [];
                        if (!is_scalar($value)) {
                            foreach ($value as $k => $v) {
                                $arr[(int)$k] = $v;
                            }
                        }
                        $decoded->$name = $arr;
                }
            }
        }

        return $decoded;
    }

    public function setSettingsAttribute($value)
    {
        $this->attributes['settings'] = json_encode($value);
    }

    public function subfields()
    {
        return $this->hasMany(EntityField::class, 'parent_field_id')->orderBy('order')->orderBy('id');
    }
}
