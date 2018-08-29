<?php

namespace Escape\Argon\Locales\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Language extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'languages';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['language_code', 'language_name', 'country_native_name', 'language_flow'];

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
    public function getLanguageCode()
    {
        return $this->language_code;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->language_name;
    }

    /**
     * @return mixed
     */
    public function getNativeName()
    {
        return $this->language_native_name;
    }

    /**
     * @return mixed
     */
    public function getTextDirection()
    {
        return $this->language_flow;
    }
}
