<?php

namespace BabeRuka\ProfileHub\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Request;

class UserDetails extends Model
{
    use HasFactory;
    protected $table = 'user_details';
    protected $primaryKey = 'details_id';
    public $incrementing = true;
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'modified_date';

    protected $fillable = [
        'user_id',
        'username',
        'firstname',
        'lastname',
        'middle_name',
        'user_bio',
        'profile_pic',
        'user_avatar',
        'create_date',
        'modified_date',
    ];

    protected $casts = [
        'details_id' => 'integer',
        'user_id' => 'integer',
        'create_date' => 'datetime',
        'modified_date' => 'datetime',
    ];

    public function __construct()
    {
        $request = Request::instance();
        $request->request->all();
    }

    public function user(){
        return $this->belongsTo('BabeRuka\ProfileHub\Models\User', 'id');
    }
}
