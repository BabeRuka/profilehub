<?php

namespace BabeRuka\ProfileHub\Models;

use Illuminate\Database\Eloquent\Model;

class UserGroups extends Model
{
    protected $table = 'user_groups';
    protected $primaryKey = 'group_id';
    public $incrementing = true;
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'modified_date';

    protected $fillable = [
        'group_name',
        'group_description',
        'group_key',
        'group_type',
        'group_admin',
        'create_date',
        'modified_date',
    ];

    protected $casts = [
        'group_id' => 'integer',
        'create_date' => 'datetime',
        'modified_date' => 'datetime',
    ];

    public function groupUsers()
    {
        return $this->hasMany(UserGroupUsers::class, 'group_id', 'group_id');
    }

    public function admin()
    {
        return $this->belongsTo(Users::class, 'group_admin', 'id');
    }

}


