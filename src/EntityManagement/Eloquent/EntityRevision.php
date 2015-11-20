<?php

namespace Escape\Argon\EntityManagement\Eloquent;

use Escape\Argon\EntityManagement\Collections\RevisionsCollection;
use Escape\Argon\EntityManagement\FieldTypes\FieldTypesManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EntityRevision extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['entity_id', 'status', 'created_by'];

    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }

    public function fields()
    {
        return $this->hasMany(FieldData::class, 'entity_revision_id');
    }

    public function newCollection(array $models = [])
    {
        return new RevisionsCollection($models);
    }

    public function field($id)
    {
        $field = $this->entity->type->field($id);
        return $this->fieldValue($field);
    }

    public function fieldById($id)
    {
        $field = $this->entity->type->fieldById($id);
        return $this->fieldValue($field);
    }

    private function fieldValue($field)
    {
        $fieldData = $this->fields()->where('field_id', $field->id)->first();

        /** @var FieldTypesManager $fieldTypeManager */
        $fieldTypeManager = app('fieldTypes');

        $fieldType = $fieldTypeManager->getType($field->field_type);

        $fieldValue = $fieldType->getValue($fieldData);

        return $fieldValue;
    }
}
