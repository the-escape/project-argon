<?php

namespace Escape\Argon\EntityManagement\Eloquent;

use Escape\Argon\EntityManagement\FieldValues\ComboFieldValue;
use Escape\Argon\Locales\Eloquent\Locale;
use Escape\Argon\Media\Eloquent\MediaItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use stdClass;

class EntityCache extends Model
{
    use SoftDeletes;

    protected $table = "entity_cache";

    protected $fillable = [
        'entity_id',
        'entity_localisation_id',
        'entity_locale_id',
        'entity_type_id',
        'entity_parent_id',
        'entity_status',
        'entity_name',
        'entity_slug',
        'entity_url',
        'entity_updated_at',
        'cache',
    ];

    public function setCacheAttribute($value)
    {
        $this->attributes['cache'] = json_encode($value);
    }

    public function getCacheAttribute($value)
    {
        return json_decode($value);
    }

    public static function cache(Entity $entity, Localisation $localisation = null)
    {
        if ($localisation === null) {
            $localisation = $entity->getDefaultLocalisation();
        }

        $latestRevision = $localisation->latestRevision();

        $values = [];
        $values['entity_id'] = $entity->id;
        $values['entity_localisation_id'] = $latestRevision->entity_localisation_id;
        $values['entity_locale_id'] = $localisation->locale_id;
        $values['entity_type_id'] = $entity->entity_type_id;
        $values['entity_parent_id'] = $entity->parent_id;
        $values['entity_status'] = $entity->status;
        $values['entity_name'] = $entity->name;
        $values['entity_slug'] = $entity->slug;
        $values['entity_url'] = null;
        $values['entity_updated_at'] = $entity->updated_at->format('Y-m-d H:i:s');

        $fields = $latestRevision->fields;

        $cacheFields = [];

        foreach ($fields as $field)
        {
            if (!$field->field)
            {
                // skip deleted field
                continue;
            }

            $fieldValue = $field->value;

            if ($field->field->field_type == 'combo')
            {
                $fieldValue = [];

                $formattedValues = $field->value;

                $subfields = $field->field->type->getSubFields();

                foreach ($formattedValues as $formattedHash => $formattedSubfields)
                {
                    $formattedSubfields = (array)$formattedSubfields->fields;

                    foreach ($formattedSubfields as $formattedSubfieldKey => $formattedSubfieldValue)
                    {
                        foreach ($subfields as $subfield)
                        {
                            if ($subfield->getId() != $formattedSubfieldKey)
                            {
                                continue;
                            }

                            if ($subfield->getKey() == 'image')
                            {
                                $formattedSubfieldValue = self::prepImageValue($formattedSubfieldValue);
                            }

                            $fieldValue[$formattedHash]['fields'][$subfield->getFieldSlug()] = [
                                'value' => $formattedSubfieldValue,
                                'type' => $subfield->getKey(),
                                'id' => $subfield->getId(),
                            ];
                        }
                    }
                }
            }

            if ($field->field->field_type == 'image')
            {
                $fieldValue = self::prepImageValue($field->value);
            }

            $cacheFields[$field->field->field_slug] = [
                //'value' => json_encode($field->attributesToArray()),
                'value' => $fieldValue,
                'type' => $field->field->field_type,
                'id' => $field->field->id,
            ];
        }

        $values['cache'] = $cacheFields;

        $origin = $entity->type->type;

        $values['entity_url'] = ($origin == 'page') ? static::getUrl($entity, $localisation) : null;

        $attributes = [
            'entity_id' => $values['entity_id'],
            'entity_localisation_id' => $values['entity_localisation_id'],
        ];

        $entityCache = static::updateOrCreate($attributes, $values);

        return $entityCache;
    }

    public static function prepImageValue($fieldValue)
    {
        $ids = [];

        foreach ($fieldValue as $key => $value)
        {
            $ids[] = $value->id;
        }

        $images = MediaItem::withTrashed()->whereIn('id', $ids)->get();

        if ($images->isEmpty())
        {
            return null;
        }
        $images = $images->keyBy('id');

        $returnValue = new stdClass();

        foreach ($fieldValue as $key => $value)
        {
            $img = new stdClass();
            $img->id = $value->id;
            $img->filename = $images[$value->id]->filename;
            $img->extension = $images[$value->id]->extension;
            $img->folder = $images[$value->id]->folder;
            $img->filesize = $images[$value->id]->filesize;
            $img->mimetype = $images[$value->id]->mimetype;
            $img->hasThumb = $images[$value->id]->hasThumb;
            $img->filesize_formatted = $images[$value->id]->filesize_formatted;

            $meta = new stdClass();
            $meta->width = $value->width;
            $meta->height = $value->height;
            $img->meta = $meta;

            $data = new stdClass();
            $data->alt = $value->alt;
            $img->data = $data;

            $returnValue->$key = $img;
        }

        return $returnValue;
    }

    public static function getUrl(Entity $entity, Localisation $localisation = null)
    {
        $segments = [];
        $parent = $entity;

        while ($parent->parent)
        {
            $segments[] = $parent->slug;
            $parent = $parent->parent;
        }

        $locale = Locale::where('id', $localisation->locale_id)->first();

        if ($locale)
        {
            $segments[] = $locale->getSlug();
        }

        $segments = array_reverse(array_filter($segments));

        $url = '/' . implode('/', $segments);

        return $url;
    }

    public function findByField($field, $value = null, $columns = array('*'))
    {
        return $this->where($field, '=', $value)->get($columns);
    }

    public function fieldExists($fieldName)
    {
        $fields = $this->cache;

        if (isset($fields->{$fieldName}))
        {
            return true;
        }

        return false;
    }

    public function field($fieldName, $default = [])
    {
        $fields = $this->cache;

        if (isset($fields->{$fieldName}))
        {
            $fieldType = app('fieldTypes')->getType($fields->{$fieldName}->type);
            $fieldValue = $fieldType->parseData($fields->{$fieldName}->value);
            return $fieldValue;
        }

        return $default;
    }

    public function combo($fieldName, $default = [])
    {
        $fields = $this->cache;

        if (isset($fields->{$fieldName}))
        {
            return new ComboFieldValue($fields->{$fieldName}->value, []);
        }

        return $default;
    }

}