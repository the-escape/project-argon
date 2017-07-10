<?php

namespace Escape\Argon\Locale\Eloquent;

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
    protected $fillable = ['name', 'languageCode', 'region', 'locale_slug'];

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getSlug()
    {
        return $this->locale_slug;
    }

    public function getLanguageCode()
    {
        return $this->languageCode;
    }
}
