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
    
    protected $fillable = [
        'group_id',
        'user_id',
        'create_date',
        'modified_date',
    ];

    protected $casts = [
        'user_group_id' => 'integer',
        'group_id' => 'integer',
        'user_id' => 'integer',
        'create_date' => 'datetime',
        'modified_date' => 'datetime',
    ];
    public function usergroups()
    {
        return $this->belongsTo('UserGroups');
    }
    public function userGroup()
    {
        return $this->belongsTo(UserGroups::class, 'group_id', 'group_id');
    }

}
