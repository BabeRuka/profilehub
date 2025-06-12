<?php

namespace BabeRuka\ProfileHub\Models;

use Illuminate\Database\Eloquent\Model;

class UserGroupUsers extends Model
{
    protected $table = 'user_group_users';
    protected $primaryKey = 'user_group_id';
    public $incrementing = true;
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'modified_date';
    public function usergroups()
    {
        return $this->belongsTo('UserGroups');
    }
}
