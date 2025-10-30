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
    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'field_id',
        'lang_code',
        'translation',
        'field_type',
        'field_settings',
        'sequence',
        'data',
        'create_date',
        'modified_date',
    ];

    /**
     * Casts for attributes
     */
    protected $casts = [
        'son_id' => 'integer',
        'field_id' => 'integer',
        'sequence' => 'integer',
        'create_date' => 'datetime',
        'modified_date' => 'datetime',
    ];

    public function user_details()
    {
        // A son may have many detail entries (via son_id)
        return $this->hasMany(UserFieldDetails::class, 'son_id', 'son_id');
    }

    public function user_field()
    {
        return $this->belongsTo(UserField::class, 'field_id', 'field_id');
    }

    public function user_field_groups()
    {
        // Relation placeholder - user_field_son doesn't directly link to groups; kept for compatibility
        return $this->belongsTo(UserFieldGroups::class);
    }
}
