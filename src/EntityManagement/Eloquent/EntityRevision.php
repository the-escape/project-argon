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

    // TODO: $name seems ambiguous
    public function field($name, EntityRevision $revision)
    {
        $field = $this->entity->type->field($name);
        return $this->fieldValue($field, $revision);
    }

    public function fieldById($id, EntityRevision $revision, $fieldDataIds=[])
    {
        $field = $this->entity->type->fieldById($id);
        return $this->fieldValue($field, $revision, $fieldDataIds);
    }

    private function fieldValue($field, EntityRevision $revision, $fieldDataIds=[])
    {
        $fieldData = null;

        if ($fieldDataIds)
        {
            $fieldDataCollection = $this->fields()
                ->whereIn('id', $fieldDataIds)
                ->where('field_id', $field->id)
                ->where('entity_revision_id', $revision->id)
                ->get();
        }
        else
        {
            $fieldDataCollection = $this->fields()->where('field_id', $field->id)->where('entity_revision_id', $revision->id)->get();
        }



        if (!$fieldDataCollection->isEmpty())
        {
            $multiple = (bool) @$field->settings->multiple;
            $fieldData = $fieldDataCollection->first();

            if ($multiple)
            {
                $flattenedDataCollection = new FieldData;
                $flattenedDataCollection->field_id = $fieldData->field_id;
                $flattenedDataCollection->entity_revision_id = $fieldData->entity_revision_id;
                $flattenedDataCollection->language = $fieldData->language;

                $agregatedValue = [];

                foreach ($fieldDataCollection as $data)
                {
                    $agregatedValue[] = $data->value;
                }

                $flattenedDataCollection->value = $agregatedValue;

                $fieldData = $flattenedDataCollection;
            }
        }

        /** @var FieldTypesManager $fieldTypeManager */
        $fieldTypeManager = app('fieldTypes');

        $fieldType = $fieldTypeManager->getType($field->field_type);

        $fieldValue = $fieldType->getValue($fieldData);

        return $fieldValue;
    }
}
