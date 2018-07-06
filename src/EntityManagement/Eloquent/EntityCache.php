<?php

namespace Escape\Argon\EntityManagement\Eloquent;

use Escape\Argon\EntityManagement\Contracts\Compressable;
use Escape\Argon\EntityManagement\FieldValues\AbstractFieldValue;
use Escape\Argon\EntityManagement\FieldValues\CacheMediaItemValue;
use Escape\Argon\EntityManagement\FieldValues\ComboFieldValue;
use Escape\Argon\Locales\Eloquent\Locale;
use Escape\Argon\Media\Eloquent\MediaItem;
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
        'entity_groups',
        'entity_redirect',
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

    public function setEntityGroupsAttribute($value)
    {
        $this->attributes['entity_groups'] = json_encode($value);
    }

    public function getEntityGroupsAttribute($value)
    {
        return json_decode($value);
    }

    public function setEntityRedirectAttribute($value)
    {
        $this->attributes['entity_redirect'] = json_encode($value);
    }

    public function getEntityRedirectAttribute($value)
    {
        return json_decode($value);
    }

    /**
     * Prepares values to create instance of EntityCache object.
     * @param Entity $entity
     * @param Localisation|null $localisation
     * @param EntityRevision|null $revision
     * @return array
     */
    private static function setCacheValues(Entity $entity, Localisation $localisation = null, EntityRevision $revision = null)
    {
        if ($localisation === null) {
            $localisation = $entity->getDefaultLocalisation();
        }

        if ($revision === null) {
            $revision = $localisation->latestRevision();
        }

        $values = [];
        $values['entity_id'] = $entity->id;
        $values['entity_localisation_id'] = $revision->entity_localisation_id;
        $values['entity_locale_id'] = $localisation->locale_id;
        $values['entity_type_id'] = $entity->entity_type_id;
        $values['entity_type_type'] = $entity->type->type;
        $values['entity_parent_id'] = $entity->parent_id;
        $values['entity_status'] = $entity->status;
        $values['entity_name'] = $entity->name;
        $values['entity_slug'] = $entity->slug;
        $values['entity_url'] = null;
        $values['entity_updated_at'] = $entity->updated_at->format('Y-m-d H:i:s');

        $fields = $revision->fields;

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

                if ($formattedValues)
                {
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
        $values['entity_redirect'] = $entity->redirect_url;
        $values['entity_groups']['group_order'] = $entity->group_order;
        $values['entity_groups']['group_render'] = $entity->group_render;


        $groups = $entity->getGroups($localisation->locale_id);

        $g = [];
        foreach ($groups as $group)
        {
            $grp = [];
            $grp['id'] = $group->id;
            $fillable = $group->getFillable();

            foreach ($fillable as $attr)
            {
                $grp[$attr] = $group->getAttribute($attr);
            }
            $g[$group->id] = $grp;
        }

        $values['entity_groups']['groups'] = $g;


        $origin = $entity->type->type;

        $values['entity_url'] = ($origin == 'page') ? static::getPageUrl($entity, $localisation) : null;

        return $values;
    }

    public static function cache(Entity $entity, Localisation $localisation = null, EntityRevision $revision = null)
    {
        $values = self::setCacheValues($entity, $localisation, $revision);

        $attributes = [
            'entity_id' => $values['entity_id'],
            'entity_localisation_id' => $values['entity_localisation_id'],
        ];

        $entityCache = static::updateOrCreate($attributes, $values);

        return $entityCache;
    }

    public static function preview(Entity $entity, Localisation $localisation = null, EntityRevision $revision = null)
    {
        $values = self::setCacheValues($entity, $localisation, $revision);

        $entityCache = new self($values);

        return $entityCache;
    }


    public static function uncache($entityId, $localeId=null)
    {
        $query = static::where('entity_id', $entityId);

        if (!is_null($localeId))
        {
            $query->where('entity_locale_id', $localeId);
        }

        $result = $query->delete();

        return $result;
    }


    /**
     * @param $fieldValue
     * @return null|stdClass
     */
    public static function prepMediaItemValue($fieldValue)
    {
        if (is_null($fieldValue))
        {
            return null;
        }

        $values = [];
        $empty = [];

        foreach ($fieldValue as $key => $value)
        {
            $id = is_object($value) ? $value->id : $value;

            if ($id)
            {
                $values[$id] = [
                    'key' => $key,
                    'alt' => @$value->alt,
                ];
            } else {
                $empty[$key] = null;
            }
        }

        if ($empty)
        {
            return $empty;
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
            [$field, $operator, $value],
        ], $columns);
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

    public function field($fieldName, $default = [], $isEmptyCheck = false)
    {
        $fields = $this->cache;

        if (isset($fields->{$fieldName}))
        {
            $fieldType = app('fieldTypes')->getType($fields->{$fieldName}->type);
            $fieldValue = $fieldType->parseData($fields->{$fieldName}->value);

            if (!$isEmptyCheck)
            {
                return $fieldValue;
            }

            if (!$fieldValue->isEmpty())
            {
                return $fieldValue;
            }
        }

        return $default;
    }

    public function combo($fieldName, $default = [], $isEmptyCheck = false)
    {
        $fields = $this->cache;

        if (isset($fields->{$fieldName}))
        {
            $fieldValue = new ComboFieldValue($fields->{$fieldName}->value);

            if (!$isEmptyCheck)
            {
                return $fieldValue;
            }

            if (!$fieldValue->isEmpty())
            {
                return $fieldValue;
            }
        }

        return $default;
    }

    public function firstField($fieldName, $default = null)
    {
        if(($f = $this->field($fieldName)) && !$f->isEmpty())
        {
            $f = $f->first();

            return $f;
        }

        return $default;
    }

    public function getId()
    {
        return $this->entity_id;
    }

    public function getUrl()
    {
        return $this->entity_url;
    }

    public function getName()
    {
        return $this->entity_name;
    }

    public function getSlug()
    {
        return $this->entity_slug;
    }

    public function getLocalisationId()
    {
        return $this->entity_localisation_id;
    }

    public function getLocaleId()
    {
        return $this->entity_locale_id;
    }

    public function getTypeId()
    {
        return $this->entity_type_id;
    }

    public function getTypeType()
    {
        return $this->entity_type_type;
    }

    public function getParentId()
    {
        return $this->entity_parent_id;
    }

    public function getStatus()
    {
        return $this->entity_status;
    }

    public function findForPath($url=null, $status=1, $trigger404=true)
    {
        $preview = request()->query->get("preview_page");

        if($preview)
        {
            $entityRepository = app()->make(EntityRepository::class);

            $entity = $entityRepository->findForPath(request());

            if (!$entity)
            {
                abort(404);
            }

            $revisionsRepository = app()->make(EntityRevisionRepository::class);
            $revision = $revisionsRepository->findByField("id", $preview)->first();

            if (!$revision)
            {
                abort(404);
            }

            $localisation = $revision->localisation;

            $cache = entityCache()->preview($entity, $localisation, $revision);

            return $cache;
        }

        $url = getUrlNoQueryString($url);

        $cache = $this
            ->where('entity_url', $url)
            ->where('entity_status', $status)
            ->first();

        if (!$cache && $trigger404)
        {
            abort(404);
        }

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
                if (array_key_exists($fieldName, $data))
                {
                    $data[$fieldName] = $field->compress();
                }
                else
                {
                    $data[$fieldName] = null;
                }
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

    public function block($slug, array $where=null)
    {
        $whereArray = ['entity_slug' => $slug];

        if (!is_null($where))
        {
            $whereArray = array_merge($whereArray, $where);
        }

        return $this->blocks($whereArray)->first();
    }

    public function blocks(array $where=null, array $order=null)
    {
        $cache = $this->where('entity_type_type', 'block');

        if (!is_null($where))
        {
            foreach ($where as $k => $v)
            {
                if (is_array($v))
                {
                    list($k, $operator, $v) = $v;

                    $cache->where($k, $operator, $v);

                    continue;
                }

                $cache->where($k, $v);
            }
        }

        if (!is_null($order))
        {
            foreach ($order as $column => $dir)
            {
                $cache->orderBy($column, $dir);
            }

        }

        return $cache->get();
    }

    public function getGroups(array $ids=null, array $settings=null)
    {
        $groups = new Collection();

        if (isset($this->entity_groups->groups))
        {
            foreach ($this->entity_groups->groups as $g)
            {
                if (!is_null($ids))
                {
                    if (!in_array($g->id, $ids))
                    {
                        continue;
                    }
                }

                $group = new EntityGroup();
                foreach ($g as $k => $v)
                {
                    $group->$k = $v;
                }
                $groups->push($group);
            }
        }

        if (!is_null($settings))
        {
            foreach($groups as $groupId => $group)
            {
                foreach ($settings as $k => $v)
                {
                    if(@$group->settings[$k] != $v)
                    {
                        $groups->forget($groupId);
                    }
                }
            }
        }

        return $groups;
    }

    public function getSortableGroups() {
        return $this->getGroups()->filter(function ($group) {
            return $group->isSortable();
        });
    }

    public function getNonSortableGroups($locale_id) {
        return $this->getGroups()->filter(function ($group) {
            return !$group->isSortable();
        });
    }


    public function getGroupOrder()
    {
        $order = [];
        $groups = $this->getSortableGroups();
        foreach ($groups as $group) {
            $order[] = $group->id;
        }
        return $order;
    }

    public function getGroupOrderString()
    {
        return implode(',', $this->getGroupOrder());
    }



    public function getRenderableGroups() {
        return $this->getGroups()->filter(function ($group) {
            return $group->isRenderable();
        });
    }

    public function getNonRenderableGroups() {
        return $this->getGroups()->filter(function ($group) {
            return !$group->isRenderable();
        });
    }

    public function getRenderableGroupOrder()
    {
        $order = [];
        $groups = $this->getRenderableGroups();
        foreach ($groups as $group) {
            $order[] = $group->id;
        }
        return $order;
    }

    public function getRenderableGroupOrderString()
    {
        return implode(',', $this->getRenderableGroupOrder());
    }


    public function isGroupRender($localeId, $groupId)
    {
        return (bool) @$this->entity_groups->group_render->{$localeId}->{$groupId};
    }

    /**
     * Returns rendered and ordered groups.
     * @param array/null $settings - optional key=>value settings based on which groups are filtered by
     * @return Collection|static
     */
    public function getRenderedGroups(array $settings=null)
    {
        $renderableGroups = $this->getRenderableGroupOrder();

        $r = new Collection();

        foreach ($renderableGroups as $renderableGroup)
        {
            if ($this->isGroupRender($this->entity_locale_id, $renderableGroup))
            {
                $r->push($renderableGroup);
            }
        }

        if ($r->count())
        {
            $r = $this->getGroups($r->toArray())->keyBy('id');

            if (!is_null($settings))
            {
                foreach($r as $groupId => $group)
                {
                    foreach ($settings as $k => $v)
                    {
                        if(@$group->settings[$k] != $v)
                        {
                            $r->forget($groupId);
                        }
                    }
                }
            }
        }

        return $r;
    }
}
