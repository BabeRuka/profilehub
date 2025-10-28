<?php

namespace BabeRuka\ProfileHub\Models;

use Illuminate\Database\Eloquent\Model;

class UserFieldSon extends Model
{
    protected $table = 'user_field_son';
    protected $primaryKey = 'son_id';
    public $incrementing = true;
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'modified_date';

    public function user_details()
    {
        return $this->hasMany('BabeRuka\ProfileHub\Models\UserFieldDetails','user_entry');
    }
    public static function user_field()
    {
        return $this->hasMany('BabeRuka\ProfileHub\Models\UserField','field_id');
    }
    public static function user_field_groups()
    {
        return $this->belongsTo('BabeRuka\ProfileHub\Models\UserFieldGroups');
    }
}
