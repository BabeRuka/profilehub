<?php

namespace BabeRuka\ProfileHub\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Users extends Model
{
    use SoftDeletes;
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
    protected $dates = [
        'deleted_at'
    ];
}
