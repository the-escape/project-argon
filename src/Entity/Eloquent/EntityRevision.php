<?php

namespace Escape\Argon\Entity\Eloquent;

use Escape\Argon\Entity\FieldTypes\FieldTypesManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EntityRevision extends Model
{
    const STATUS_DRAFT = 1;
    const STATUS_PUBLISHED = 2;
    const STATUS_PREVIOUSLY_PUBLISHED = 3;
    const STATUS_PREVIEW = 4;

    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['entity_localisation_id', 'status', 'created_at', 'updated_at', 'created_by'];

    public function isStatus($statusId)
    {
        return $this->status == $statusId;
    }

    public static function getStatusView(Entity $entity)
    {
        $statusViews = [
            1 => view('argon.entity::partials.statuses.published', ['showText' => true]),
            0 => view('argon.entity::partials.statuses.previously-published', ['showText' => true]),
        ];

        return isset($statusViews[$entity->status]) ? $statusViews[$entity->status] : '';
    }

    public function entityRevisionGroups()
    {
        return $this->hasMany(EntityRevisionGroup::class);
    }

    public function fieldData()
    {
        return $this->hasMany(FieldData::class);
    }

    public function localisation()
    {
        return $this->belongsTo(Localisation::class, 'entity_localisation_id');
    }

    public function fields()
    {
        return $this->hasMany(FieldData::class, 'entity_revision_id');
    }
    /*
    public function newCollection(array $models = [])
    {
        return new RevisionsCollection($models);
    }
    */
    // TODO: $name seems ambiguous
    public function field($name)
    {
        $field = $this->localisation->entity->type->field($name);

        if (!$field) {
            throw new \RuntimeException("Undefined field '{$name}'.");
        }

        return $this->fieldValue($field);
    }

    public function fieldById($id, $fieldDataIds = [])
    {
        $field = $this->entity->type->fieldById($id);
        return $this->fieldValue($field, $fieldDataIds);
    }

    private function fieldValue($field, $fieldDataIds = [])
    {
        $fieldData = null;

        if ($fieldDataIds) {
            $fieldDataCollection = $this->fields()
                ->whereIn('id', $fieldDataIds)
                ->where('field_id', $field->id)
                ->where('entity_revision_id', $this->id)
                ->get();
        } else {
            $fieldDataCollection = $this->fields()->where('field_id', $field->id)
                ->where('entity_revision_id', $this->id)->get();
        }

        $fieldData = $fieldDataCollection->first();

        /** @var FieldTypesManager $fieldTypeManager */
        $fieldTypeManager = app('fieldTypes');

        $fieldType = $fieldTypeManager->getType($field->field_type)->setField($field);

        $fieldValue = $fieldType->parseData($fieldData);

        return $fieldValue;
    }

    public function getFields()
    {
        return $this->fields->keyBy('field_id')->map(
            function ($f) {
                $field = $f->field;

                if ($field !== null)
                {
                    return $field->type->parseData($f);
                }

                return null;
            }
        );
    }

    public function getField($fieldId)
    {
        /** @var EntityField $f */
        $f = $this->fields()->where('field_id', $fieldId)->first();
        if ($f === null) {
            // Latest revision doesn't contain this field - it's probably new.
            return null;
        } else {
            return $f->field->type->parseData($f);
        }
    }
}
