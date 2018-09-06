<?php

namespace Escape\Argon\Menus\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use SoftDeletes;

    protected $table = 'menus';

    protected $fillable = ["menu", "slug", "name", "locale_id"];

    public function locale()
    {
        return $this->hasOne('Escape\Argon\Locales\Eloquent\Locale', 'id', 'locale_id');
    }

    public function getMenuAttribute($value)
    {
        if (!$value)
        {
            return [];
        }

        return json_decode($value);
    }

    public function setMenuAttribute($value)
    {
        if (!isJson($value))
        {
            $value = json_encode($value);
        }

        $this->attributes['menu'] = $value;
    }

    public function json()
    {
        return $this->attributes['menu'];
    }
}
