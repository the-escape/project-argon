<?php

namespace Escape\Argon\EntityManagement\Eloquent;

use Carbon\Carbon;
use Escape\Argon\EntityManagement\Eloquent\Collections\LocalisationCollection;
use Escape\Argon\EntityManagement\FieldTypes\FieldTypesManager;
use Escape\Argon\EntityManagement\RevisionStatus;
use Escape\Argon\Frontend\Page;
use Escape\Argon\Locales\Eloquent\Locale;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Escape\Argon\Core\Http\Request;
use Illuminate\Support\Collection;

/**
 * Class Entity
 *
 * @property-get int id
 * @property string name
 * @property string slug
 * @property int|null parent_id
 * @property int entity_type_id
 * @property int owner_id
 * @property int status
 * @property Carbon created_at
 * @property Carbon updated_at
 * @property Carbon deleted_at
 */
class Entity extends Model
{
    protected $children = [];

    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'parent_id', 'entity_type_id', 'owner_id', 'status', 'redirect_url', 'group_order'];

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

    /**
     * @param Locale $locale
     * @return Localisation
     */
    public function getLocalisation(Locale $locale)
    {
        return $this->localisations()->where('locale_id', $locale->getId())->first();
    }

    /**
     * @return LocalisationCollection
     */
    public function getLocalisations()
    {
        return $this->localisations;
    }

    public function getGroups($locale_id)
    {
        /** @var EntityGroupRepository $repo */
        $repo = app()->make(EntityGroupRepository::class);
        $groups =  $repo->getUsedGroupsByEntityType($this->type->id)->each(
            function (EntityGroup $item) {
                $item->setEntity($this);
            }
        );

        if (($this->group_order instanceof \stdClass) && property_exists($this->group_order, $locale_id)) {
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

    public function getSortableGroups($locale_id) {
        return $this->getGroups($locale_id)->filter(function ($group) {
            return $group->isSortable();
        });
    }

    public function getNonSortableGroups($locale_id) {
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

    public function getId()
    {
        return $this->id;
    }

    public function toPage(Request $request=null)
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

    public function setGrouporderAttribute($value)
    {
        $this->attributes['group_order'] = json_encode($value);
    }

    public function getGrouporderAttribute($value)
    {
        return json_decode($value);
    }

}
