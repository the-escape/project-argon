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

    public function fields()
    {
        return $this->hasMany(EntityField::class)->orderBy('entity_group_id')->orderBy( 'name');
    }

    /**
     * @param string $name
     * @return EntityField
     */
    public function field($name)
    {
        return $this->fields()->where('name', $name)->first();
    }

    /**
     * @param int $id
     * @return EntityField
     */
    public function fieldById($id)
    {
        return $this->fields()->where('id', $id)->first();
    }


    public function getGroupsAttribute()
    {
        $groups = [];

        foreach ($this->fields as $field) {
            $groups[$field->entity_group_id][] = $field;
        }

        return $groups;
    }

}
