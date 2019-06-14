<?php

namespace Escape\Argon\EntityManagement\Eloquent;

use Carbon\Carbon;
use Escape\Argon\EntityManagement\Eloquent\Collections\LocalisationCollection;
use Escape\Argon\EntityManagement\FieldTypes\FieldTypesManager;
use Escape\Argon\EntityManagement\RevisionStatus;
use Escape\Argon\Frontend\Page;
use Escape\Argon\Authentication\User;
use Escape\Argon\Locales\Eloquent\Locale;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Escape\Argon\Core\Http\Request;
use Illuminate\Support\Collection;
use stdClass;
use Illuminate\Support\Facades\DB;
use Escape\Argon\Helpers\Solr;
use Escape\Argon\Events\PageSaved;

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
    protected $fillable = ['name', 'slug', 'parent_id', 'order', 'entity_type_id', 'owner_id', 'status', 'redirect_url', 'group_order', 'group_render'];

    public function addChild(Entity $child)
    {
        $this->children[] = $child;

        if(isset($child->order))
        {
            usort($this->children, function($child1, $child2) {
                return $child1->order > $child2->order;
            });
        }
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

    public function hasLocalisation($localeId)
    {
        $locale = Locale::find($localeId);

        return $locale ? $this->getLocalisation($locale)->exists : false;
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



    public function getRenderableGroups($locale_id) {
        return $this->getGroups($locale_id)->filter(function ($group) {
            return $group->isRenderable();
        });
    }

    public function getNonRenderableGroups($locale_id) {
        return $this->getGroups($locale_id)->filter(function ($group) {
            return !$group->isRenderable();
        });
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

    public function clonePage()
    {
        DB::beginTransaction();

        try
        {
            $solr = app()->make(Solr::class);

            self::where('parent_id', $this->parent_id)
                      ->where('order', '>', $this->order)
                      ->increment('order');

            $clonedEntity = $this->replicate();
            $clonedEntity->order += 1;
            $clonedEntity->status = 0;
            $clonedEntity->slug = findUniqueSlug($this->slug, $this->parent_id);
            $clonedEntity->save();

            $localisations = $this->localisations;

            foreach($localisations as $localisation)
            {
                $clonedLocalisation = $localisation->replicate();
                $clonedLocalisation->entity_id = $clonedEntity->id;
                $clonedLocalisation->save();

                $revision = $localisation->publishedRevision();

                $clonedRevision = $revision->replicate();
                $clonedRevision->entity_localisation_id = $clonedLocalisation->id;
                $clonedRevision->save();

                $fields = $revision->fields;

                foreach($fields as $field)
                {
                    $clonedField = $field->replicate();
                    $clonedField->entity_revision_id = $clonedRevision->id;
                    $clonedField->save();
                }

                $solr->indexEntity($clonedEntity, $clonedLocalisation);

                EntityCache::cache($clonedEntity, $clonedLocalisation);

                event(new PageSaved($clonedEntity, $clonedLocalisation, request()));
            }
        }
        catch(\Exception $e)
        {
            DB::rollback();

            return null;
        }

        DB::commit();

        return $clonedEntity;
    }
}
