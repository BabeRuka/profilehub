<?php

namespace BabeRuka\ProfileHub\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    public $incrementing = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    protected $fillable = [
        'name',
        'email', 
        'password', 
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function details()
    {
        return $this->hasOne('BabeRuka\ProfileHub\Models\UserDetails::class', 'user_id', 'id');
    } 
}
