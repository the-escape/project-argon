<?php

namespace Escape\Argon\EntityManagement\Eloquent;

use Escape\Argon\EntityManagement\Contracts\Compressable;
use Escape\Argon\EntityManagement\FieldValues\AbstractFieldValue;
use Escape\Argon\EntityManagement\FieldValues\CacheMediaItemValue;
use Escape\Argon\EntityManagement\FieldValues\ComboFieldValue;
use Escape\Argon\Locales\Eloquent\Locale;
use Escape\Argon\Media\Eloquent\MediaItem;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;
use stdClass;

class EntityCache extends Model implements Compressable
{
    use SoftDeletes;

    protected $table = "entity_cache";

    protected $fillable = [
        'entity_id',
        'entity_localisation_id',
        'entity_locale_id',
        'entity_type_id',
        'entity_type_type',
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
        $values['entity_type_type'] = $entity->type->type;
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
                                $formattedSubfieldValue = self::prepMediaItemValue($formattedSubfieldValue);
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
                $fieldValue = self::prepMediaItemValue($field->value);
            }

            if ($field->field->field_type == 'file')
            {
                $fieldValue = self::prepMediaItemValue($field->value);
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

        $values['entity_url'] = ($origin == 'page') ? static::getPageUrl($entity, $localisation) : null;

        $attributes = [
            'entity_id' => $values['entity_id'],
            'entity_localisation_id' => $values['entity_localisation_id'],
        ];

        $entityCache = static::updateOrCreate($attributes, $values);

        return $entityCache;
    }

    /**
     * @param $fieldValue
     * @return null|stdClass
     */
    public static function prepMediaItemValue($fieldValue)
    {
        $values = [];

        foreach ($fieldValue as $key => $value)
        {
            $id = is_object($value) ? $value->id : $value;
            if ($id)
            {
                $values[$id] = [
                    'key' => $key,
                    'alt' => @$value->alt,
                ];
            }
        }

        $mediaItems = MediaItem::withTrashed()->whereIn('id', array_keys($values))->get();

        if ($mediaItems->isEmpty())
        {
            return null;
        }

        $returnValue = [];

        // Can't add more properties to $item as these are the onlu reliable ones.
        // Properties like width, height, filesize cat me affected without changing cache,
        // However asset's i and url will not change, so safe to use.
        // And alt text change will trigger cache update so we can use it here safely.
        foreach ($values as $id => $value)
        {
            foreach ($mediaItems as $mediaItem)
            {
                if ($mediaItem->getId() != $id)
                {
                    continue;
                }

                $item = new stdClass();
                $item->id = $id;
                $item->url = $mediaItem->getUrl();
                $item->alt = $value['alt'];

                $returnValue[$value['key']] = $item;
            }
        }

        return $returnValue;
    }

    public static function getPageUrl(Entity $entity, Localisation $localisation = null)
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

    /**
     * Example call
     * $cache = $entityCache->findByField('entity_url', $url)->first();
     *
     * @param $field
     * @param null $value
     * @param string $operator
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function findByField($field, $value = null, $operator = '=', $columns = array('*'))
    {
        return $this->findByFields([
            [$field, '=', $value],
        ]);
    }



    /**
     * Example calls:
     *
     * Easy/quick syntax, without passing operators - defaults to '=' for each key => value
     * $cache = $entityCache->findByFields([
     *     'entity_url' => $url,
     *     'entity_status' => 1,
     * ])->first();
     *
     * Syntax for when different comparison operators are needed to resulting where queries
     * $cache = $entityCache->findByFields([
     *     ['entity_url', '=', $url],
     *     ['entity_status', '=', 1],
     * ])->first();
     *
     * Mixed syntax - working, but not recommended
     * $cache = $entityCache->findByFields([
     *     ['entity_url', '=', $url],
     *     ['entity_status', 1],
     * ])->first();
     *
     * Mixed syntax - working, but not recommended
     * $cache = $entityCache->findByFields([
     *     ['entity_url', '=', $url],
     *     'entity_status' => 1,
     * ])->first();
     *
     * @param array $array
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function findByFields(array $array, $columns = array('*'))
    {
        $query = $this->newQuery();
        foreach ($array as $k => $v)
        {
            if (is_array($v))
            {
                $count = count($v);
                if ($count == 3)
                {
                    list($field, $operator, $value) = $v;
                    $query->where($field, $operator, $value);
                }
                elseif ($count == 2)
                {
                    list($field, $value) = $v;
                    $query->where($field, '=', $value);
                }
            }
            else
            {
                $query->where($k, '=', $v);
            }
        }

        return $query->get($columns);
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
            return new ComboFieldValue($fields->{$fieldName}->value);
        }

        return $default;
    }

    public function getUrl()
    {
        return $this->entity_url;
    }

    public function findForPath($url=null, $status=1)
    {
        if (is_null($url))
        {
            $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        }

        $cache = $this
            ->where('entity_url', $url)
            ->where('entity_status', $status)
            ->first();

        return $cache;
    }


    public function compress(array $fieldNames=['*'])
    {
        $data = [];

        if ($fieldNames == ['*'])
        {
            if ($this->cache)
            {
                $fields = (array)$this->cache;
                $fieldNames = array_keys($fields);
            }
        }

        foreach ($fieldNames as $fieldName)
        {
            $field = $this->field($fieldName);
            if ($field instanceof AbstractFieldValue)
            {
                $data[$fieldName] = $field->compress();
            }
            elseif ($field instanceof CacheMediaItemValue)
            {
                $data[$fieldName] = $field->compress();
            }
        }

        return $data;
    }

    public function toJson($options = 0)
    {
        $values = $this->compress();
        return json_encode($values, $options);
    }
}
