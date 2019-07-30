<?php

namespace Escape\Argon\EntityManagement\Eloquent;

use Escape\Argon\Authentication\User;
use Escape\Argon\EntityManagement\Collections\RevisionsCollection;
use Escape\Argon\EntityManagement\FieldTypes\FieldTypesManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Escape\Argon\EntityManagement\RevisionStatus;
use Illuminate\Support\Facades\DB;
use Exception;
use stdClass;
use Illuminate\Support\Collection;

class EntityRevision extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['entity_localisation_id', 'status', 'entity_groups', 'entity_redirects', 'created_by'];

    public function localisation()
    {
        return $this->belongsTo(Localisation::class, 'entity_localisation_id');
    }

    public function fields()
    {
        return $this->hasMany(FieldData::class, 'entity_revision_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function userWithTrashed()
    {
        return $this->belongsTo(User::class, 'created_by')->withTrashed();
    }

    public function newCollection(array $models = [])
    {
        return new RevisionsCollection($models);
    }

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

    public function getStatusName()
    {
        switch($this->status)
        {
            case RevisionStatus::DRAFT:
                return 'Draft';
            case RevisionStatus::PREVIOUSLY_PUBLISHED:
                return 'Previously published';
            case RevisionStatus::PUBLISHED:
                return 'Published';
            case RevisionStatus::PREVIEW:
                return 'Preview';
            case RevisionStatus::LEGACY_REVISION:
                return 'Legacy revision';
        }
    }

    public function setEntityRedirectsAttribute($value)
    {
        $this->attributes['entity_redirects'] = json_encode($value);
    }

    public function getEntityRedirectsAttribute($value)
    {
        return json_decode($value);
    }

    public function setEntityGroupsAttribute($value)
    {
        $this->attributes['entity_groups'] = json_encode($value);
    }

    public function getEntityGroupsAttribute($value)
    {
        return json_decode($value);
    }

    public function publishRevision()
    {
        DB::beginTransaction();

        try
        {
            self::where('entity_localisation_id', $this->entity_localisation_id)
                ->where('status', RevisionStatus::PUBLISHED)
                ->update(['status' => RevisionStatus::PREVIOUSLY_PUBLISHED]);

            $this->status = RevisionStatus::PUBLISHED;
            $this->save();
        }
        catch(Exception $e)
        {
            DB::rollBack();

            return false;
        }

        DB::commit();

        return true;
    }

    public function isGroupRender($groupId)
    {
        $localisation = $this->localisation;
        $entity = $localisation->entity;
        $localeId = $localisation->locale_id;

        if (!empty($this->entity_groups->group_render))
        {
            $group_render = $this->entity_groups->group_render;
        }
        else
        {
            $group_render = $entity->group_render;
        }

        return (bool) @$group_render->{$localeId}->{$groupId};
    }

    public function getGroups()
    {
        $localisation = $this->localisation;
        $entity = $localisation->entity;
        $locale_id = $localisation->locale_id;
        $type_id = $entity->entity_type_id;

        /** @var EntityGroupRepository $repo */
        $repo = app()->make(EntityGroupRepository::class);
        $groups =  $repo->getUsedGroupsByEntityType($type_id, ['order', 'id'])->each(
            function (EntityGroup $item) use ($entity) {
                $item->setEntity($entity);
            }
        );

        if (!empty($this->entity_groups->group_order))
        {
            $group_order = $this->entity_groups->group_order;
        }
        else
        {
            $group_order = $entity->group_order;
        }

        if (($group_order instanceof stdClass) && property_exists($group_order, $locale_id)) {
            $intended_order = array_filter(explode(',', $group_order->$locale_id));

            $ordered = new Collection;

            foreach ($intended_order as $group_id) {
                foreach ($groups as $idx => $group) {
                    if ($group->id == $group_id) {
                        $ordered->push($groups->pull($idx));
                    }
                }
            }

            if(!$groups->isEmpty()){
                foreach ($groups as $idx => $group) {
                    $ordered->push($groups->pull($idx));
                }
            }

            $groups = $ordered;
        }

        return $groups;
    }
}
