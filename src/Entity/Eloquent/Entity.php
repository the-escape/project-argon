<?php

namespace Escape\Argon\Entity\Eloquent;

use stdClass;

use Escape\Argon\Frontend\Page;
use Escape\Argon\Core\Http\Request;
use Escape\Argon\Locale\Eloquent\Locale;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entity extends Model
{
    use SoftDeletes;

    protected $children = [];
    protected $fillable = [
        'name',
        'slug',
        'parent_id',
        'entity_type_id',
        'owner_id',
        'status',
        'redirect_url',
        'group_order',
        'group_render',
    ];

    public function getId()
    {
        return $this->id;
    }

    public function addChild(Entity $child)
    {
        //TODO add support for ordering.
        $this->children[] = $child;
    }

    public function hasChildren()
    {
        return !empty($this->children);
    }

    public function getChildren()
    {
        return $this->children;
    }

    public function parent()
    {
        return $this->belongsTo(Entity::class, 'parent_id');
    }

    public function type()
    {
        return $this->belongsTo(EntityType::class, 'entity_type_id');
    }

    public function revisions()
    {
        return $this->hasMany(EntityRevision::class);
    }

    protected function localisations()
    {
        return $this->hasMany(Localisation::class);
    }

    public function getDefaultLocalisation()
    {
        return $this->localisations()->orderBy('created_at', 'ASC')->first();
    }

    public function getLocalisation(Locale $locale)
    {
        return $this->localisations()->where('locale_id', $locale->getId())->first();
    }

    public function hasLocalisation($localeId)
    {
        $locale = Locale::find($localeId);

        return $locale ? $this->getLocalisation($locale)->exists : false;
    }

    public function getLocalisations()
    {
        return $this->localisations;
    }

    public function getGroups($locale_id)
    {
        $repo = app()->make(EntityGroupRepository::class);
        $groups =  $repo->getUsedGroupsByEntityType($this->type->id, ['order', 'id'])->each(
            function (EntityGroup $item) {
                $item->setEntity($this);
            }
        );

        if (($this->group_order instanceof stdClass) && property_exists($this->group_order, $locale_id)) {
            $group_order = array_filter(explode(',', $this->group_order->$locale_id));

            $ordered = new Collection;

            foreach ($group_order as $group_id) {
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

    public function getSortableGroups($locale_id)
    {
        return $this->getGroups($locale_id)->filter(function ($group) {
            return $group->isSortable();
        });
    }

    public function getNonSortableGroups($locale_id)
    {
        return $this->getGroups($locale_id)->filter(function ($group) {
            return !$group->isSortable();
        });
    }

    public function getGroupOrder($locale_id)
    {
        $order = [];
        $groups = $this->getSortableGroups($locale_id);
        foreach ($groups as $group) {
            $order[] = $group->id;
        }
        return $order;
    }

    public function getGroupOrderString($locale_id)
    {
        return implode(',', $this->getGroupOrder($locale_id));
    }

    public function getRenderableGroups($locale_id)
    {
        return $this->getGroups($locale_id)->filter(function ($group) {
            return $group->isRenderable();
        });
    }

    public function getNonRenderableGroups($locale_id)
    {
        return $this->getGroups($locale_id)->filter(function ($group) {
            return !$group->isRenderable();
        });
    }

    public function getRenderedGroups($localeId)
    {
        $groupIds = array_keys((array) $this->group_render->$localeId, EntityGroup::RENDERED);

        return $this->getGroups($localeId)->filter(function ($group) use ($groupIds) {
            return in_array($group->id, $groupIds);
        })->keyBy('id');
    }

    public function getRenderableGroupOrder($locale_id)
    {
        $order = [];
        $groups = $this->getRenderableGroups($locale_id);
        foreach ($groups as $group) {
            $order[] = $group->id;
        }
        return $order;
    }

    public function getRenderableGroupOrderString($locale_id)
    {
        return implode(',', $this->getRenderableGroupOrder($locale_id));
    }

    public function isGroupRender($localeId, $groupId)
    {
        $group_render = $this->group_render;
        return (bool) @$group_render->{$localeId}->{$groupId};
    }

    public function toPage(Request $request = null)
    {
        return new Page($this, $request);
    }

    public function setRedirectUrlAttribute($value)
    {
        $this->attributes['redirect_url'] = json_encode($value);
    }

    public function getRedirectUrlAttribute($value)
    {
        return json_decode($value);
    }

    public function setGroupOrderAttribute($value)
    {
        $this->attributes['group_order'] = json_encode($value);
    }

    public function getGroupOrderAttribute($value)
    {
        return json_decode($value);
    }

    public function setGroupRenderAttribute($value)
    {
        $this->attributes['group_render'] = json_encode($value);
    }

    public function getGroupRenderAttribute($value)
    {
        return json_decode($value);
    }

    public function getPublishedRevision($revisionId = null)
    {
        return $this->getCurrentLocalisation()->publishedRevision($revisionId);
    }

    public function getCurrentLocalisation()
    {
        $locale = request()->getArgonLocale();
        $localisation = $this->getLocalisation($locale);

        if ($localisation) {
            return $localisation;
        } else {
            return $this->getDefaultLocalisation();
        }
    }
}
