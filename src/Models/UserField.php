<?php

namespace BabeRuka\ProfileHub\Models;

use Illuminate\Database\Eloquent\Model;

class UserField extends Model
{
    protected $table = 'user_field';
    protected $primaryKey = 'field_id';
    public $incrementing = true;
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'modified_date';

    public function user_field_son()
    {
        return $this->belongsTo('BabeRuka\ProfileHub\Models\UserFieldSon','field_id');
    }
    public function user_field_groups()
    {
        return $this->belongsTo('BabeRuka\ProfileHub\Models\UserFieldGroups');
    }
    
}
