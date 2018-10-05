<?php

namespace Escape\Argon\Locales\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MultiDomain extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    protected $table = 'multidomain';

    /**
     * @var array
     */
    protected $fillable = [
        'domain_url', 'locale_id'
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
    public function getDomainUrl()
    {
        return $this->domain_url;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function locale()
    {
        return $this->hasOne('Escape\Argon\Locales\Eloquent\Locale', 'id', 'locale_id');
    }
}
