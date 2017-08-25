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
            return new ComboFieldValue($fields->{$fieldName}->value, []);
        }

        return $default;
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

}
