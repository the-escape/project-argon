<?php

namespace Escape\Argon\EntityManagement\Eloquent;

use Escape\Argon\EntityManagement\Eloquent\Collections\LocalisationCollection;
use Escape\Argon\EntityManagement\RevisionStatus;
use Escape\Argon\Locales\Eloquent\Locale;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Localisation extends Model
{
    use SoftDeletes;

    protected $table = 'entity_localisations';

    protected $fillable = ['entity_id', 'locale_id'];

    public function entity()
    {
        return $this->belongsTo(Entity::class, 'entity_id');
    }

    public function revisions()
    {
        return $this->hasMany(EntityRevision::class, 'entity_localisation_id');
    }

    /**
     * @return EntityRevision
     */
    public function latestRevision()
    {
        return $this->revisions()->orderBy('created_at', 'desc')->first();
    }

    /**
     * @return EntityRevision
     */
    public function publishedRevision()
    {
        return $this->revisions()->where('status', RevisionStatus::PUBLISHED)->orderBy('created_at', 'desc')->first();
    }

    public function locale()
    {
        return $this->belongsTo(Locale::class, 'locale_id');
    }

    /**
     * @return Locale
     */
    public function getLocale()
    {
        return $this->locale;
    }

    public function getId()
    {
        return (int)$this->id;
    }

    public function getLocaleId()
    {
        return (int)$this->attributes['locale_id'];
    }

    public function newCollection(array $models = [])
    {
        return new LocalisationCollection($models);
    }
}
