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
    protected $fillable = ['name', 'order', 'entity_type_id'];

    protected $entity;

    public function fields()
    {
        return $this->hasMany(EntityField::class)->orderBy('entity_group_id')->orderBy('order')->orderBy('name');
    }

    public function getFields()
    {
        $fields = $this->fields->map(function (EntityField $f) { return $f->type; });

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

}
