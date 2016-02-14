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
class EntityType extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    // Get all fields except combo subfields.
    // Combo field should be pulled here as a top level (standard) field, not its children.
    // However, when method chained via field() and fieldById() methods allow full lookup to get subfield's value etc.
    public function fields(array $where = ['parent_field_id' => 0])
    {
        $fields = $this->hasMany(EntityField::class);

        foreach ($where as $field => $value) {
            if (is_array($value)) {
                list($field, $condition, $val) = $value;
                $fields->where($field, $condition, $val);
            } else {
                $fields->where($field, '=', $value);
            }
        }
        //return $fields->orderBy('entity_group_id')->orderBy('order')->orderBy('name');
        return $fields->orderBy('entity_group_id')->orderBy('order')->orderBy('name');
    }

    /**
     * @param string $name
     * @return EntityField
     */
    public function field($name)
    {
        return $this->fields([])->where('name', $name)->first();
    }

    /**
     * @param int $id
     * @return EntityField
     */
    public function fieldById($id)
    {
        return $this->fields([])->where('id', $id)->first();
    }

    public function groups()
    {
        return $this->hasMany(EntityGroup::class)->orderBy('order')->orderBy('id');
    }

    public function getId()
    {
        return $this->id;
    }
}
