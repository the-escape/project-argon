<?php

namespace Escape\Argon\Locales\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Locale extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'language_id', 'country_id', 'region_id', 'locale_slug'];

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->locale_slug;
    }

    /**
     * @return mixed
     */
    public function getLanguageId()
    {
        return $this->language_id;
    }

    /**
     * @return mixed
     */
    public function getCountryId()
    {
        return $this->country_id;
    }

    /**
     * @return mixed
     */
    public function getRegionId()
    {
        return $this->region_id;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function language()
    {
        return $this->hasOne('Escape\Argon\Locales\Eloquent\Language', 'id', 'language_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function country()
    {
        return $this->hasOne('Escape\Argon\Locales\Eloquent\Country', 'id', 'country_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function region()
    {
        return $this->hasOne('Escape\Argon\Locales\Eloquent\Region', 'id', 'region_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entityCache()
    {
        return $this->belongsTo('Escape\Argon\EntityManagement\EntityCache', 'entity_locale_id', 'id');
    }
}
