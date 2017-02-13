<?php

namespace Escape\Argon\Entity\Eloquent;

use Escape\Argon\Entity\Eloquent\Collections\LocalisationCollection;
use Escape\Argon\Entity\RevisionStatus;
use Escape\Argon\Locale\Eloquent\Locale;
use Exception;
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
    public function publishedRevision($revisionId = null)
    {
        $revision = $this->revisions();

        if (!is_null($revisionId)) {
            $revision = $revision->where('id', '=', $revisionId);
        } else {
            $revision = $revision->whereIn('status', [EntityRevision::STATUS_PUBLISHED]);
        }

        $revision = $revision->orderBy('created_at', 'desc')->first();

        if ($revision === null) {
            throw new Exception('Entity has no published revisions.');
        }

        return $revision;
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
