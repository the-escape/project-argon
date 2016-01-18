<?php

namespace Escape\Argon\EntityManagement\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FieldData extends Model
{
    use SoftDeletes;

    protected $table = 'field_data';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['field_id', 'entity_revision_id', 'language', 'value'];

    public function field()
    {
        return $this->belongsTo(EntityField::class);
    }

    public function getValueAttribute($value)
    {
        return json_decode($value);
    }

    public function setValueAttribute($value)
    {
        $this->attributes['value'] = json_encode($value);
    }
}
