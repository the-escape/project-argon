<?php

namespace Escape\Argon\Locales\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'countries';

    /**
     * @var array
     */
    protected $fillable = [
        'iso_code', 'iso_code_3', 'iso_numeric', 'fips_code', 'country_name', 'country_capital', 'continent_code',
        'top_level_domain', 'currency_code', 'currency_name', 'telephone_code', 'postal_code_format', 'postal_code_regex',
        'languages', 'neighbours'
    ];

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
    public function getIsoCode()
    {
        return $this->iso_code;
    }

    /**
     * @return mixed
     */
    public function getIsoCode3()
    {
        return $this->iso_code_3;
    }

    /**
     * @return mixed
     */
    public function getIsoNumeric()
    {
        return $this->iso_numeric;
    }

    /**
     * @return mixed
     */
    public function getFipsCode()
    {
        return $this->fips_code;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->country_name;
    }

    /**
     * @return mixed
     */
    public function getCapital()
    {
        return $this->country_capital;
    }

    /**
     * @return mixed
     */
    public function getContinentCode()
    {
        return $this->continent_code;
    }

    /**
     * @return mixed
     */
    public function getTld()
    {
        return $this->top_level_domain;
    }

    /**
     * @return mixed
     */
    public function getCurrencyCode()
    {
        return $this->currency_code;
    }

    /**
     * @return mixed
     */
    public function getCurrencyName()
    {
        return $this->currency_name;
    }

    /**
     * @return mixed
     */
    public function getTelephoneCode()
    {
        return $this->telephone_code;
    }

    /**
     * @return mixed
     */
    public function getPostalCodeFormat()
    {
        return $this->postal_code_format;
    }

    /**
     * @return mixed
     */
    public function getPostalCodeRegex()
    {
        return $this->postal_code_regex;
    }

    /**
     * @return mixed
     */
    public function getLanguages()
    {
        return $this->languages;
    }

    /**
     * @return mixed
     */
    public function getNeighbours()
    {
        return $this->neighbours;
    }
}
