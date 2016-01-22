<?php

namespace Escape\Argon\EntityManagement\Eloquent;

use Escape\Argon\EntityManagement\Eloquent\Collections\LocalisationCollection;
use Escape\Argon\EntityManagement\FieldTypes\FieldTypesManager;
use Escape\Argon\EntityManagement\RevisionStatus;
use Escape\Argon\Locales\Eloquent\Locale;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entity extends Model
{
    protected $children = [];

    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'parent', 'entity_type_id', 'owner_id'];

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

    public function field($name)
    {
        if ($revision = $this->latest())
        {
            return $revision->field($name, $revision);
        }
        return $revision;
    }

    public function fieldById($id, $fieldDataIds=[])
    {
        if ($revision = $this->latest())
        {
            return $revision->fieldById($id, $revision, $fieldDataIds);
        }
        return $revision;
    }

    public function type()
    {
        return $this->belongsTo(EntityType::class, 'entity_type_id');
    }

    public function revisions()
    {
        return $this->hasMany(EntityRevision::class);
    }

    public function getLatestAttribute()
    {
        return $this->latest();
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

    public function getGroups()
    {
        /** @var EntityGroupRepository $repo */
        $repo = app()->make(EntityGroupRepository::class);
        return $repo->getUsedGroupsByEntityType($this->type->id)->each(function(EntityGroup $item) { $item->setEntity($this); } );
    }


    public function getId()
    {
        return $this->id;
    }
}
