<?php

namespace BabeRuka\ProfileHub\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFieldGroups extends Model
{
    use HasFactory;

    protected $table = 'user_field_groups';
    protected $primaryKey = 'group_id';
    public $incrementing = true;
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'modified_date';

    public static function user_field()
    {
        return $this->belongsTo('BabeRuka\ProfileHub\Models\UserField');
    }
}
