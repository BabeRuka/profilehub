<?php

namespace BabeRuka\ProfileHub\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfiles extends Model
{
    protected $table = 'user_profiles';
    protected $primaryKey = 'profile_id';
    public $incrementing = true;
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'modified_date';
    /**
     * Get the notes for the users.
     */
    public function user()
    {
        return $this->hasMany('BabeRuka\ProfileHub\Models\User');
    }
}
