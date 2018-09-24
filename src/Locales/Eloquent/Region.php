<?php

namespace Escape\Argon\Locales\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Region extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'regions';

    /**
     * @var array
     */
    protected $fillable = [
        'region_name', 'display_name'
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
    public function getName()
    {
        return $this->region_name;
    }

    /**
     * @return mixed
     */
    public function getDisplayName()
    {
        return $this->region_name;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function locale()
    {
        return $this->hasMany('Escape\Argon\Locales\Eloquent\Locale', 'id', 'region_id');
    }
}
