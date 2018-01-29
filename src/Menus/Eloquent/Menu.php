<?php

namespace Escape\Argon\Menus\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use SoftDeletes;

    protected $table = 'menus';

    protected $fillable = ["menu", "slug", "name", ];

    public function getMenusAttribute($value)
    {
        return json_decode($value);
    }

    public function setMenusAttribute($value)
    {
        if (!isJson($value))
        {
            $value = json_encode($value);
        }

        $this->attributes['menu'] = $value;
    }
}
