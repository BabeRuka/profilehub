<?php

namespace BabeRuka\ProfileHub\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFieldDetailsData extends Model
{
    use HasFactory;
    protected $table = 'user_field_details_data';
    protected $primaryKey = 'data_id';
    public $incrementing = true;
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'modified_date';
    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'field_id',
        'son_id',
        'user_id',
        'user_entry',
        'user_rows',
        'details_data',
        'sequence',
        'create_date',
        'modified_date',
    ];

    /**
     * Casts for attributes
     */
    protected $casts = [
        'data_id' => 'integer',
        'field_id' => 'integer',
        'son_id' => 'integer',
        'user_id' => 'integer',
        'user_rows' => 'integer',
        'sequence' => 'integer',
        'create_date' => 'datetime',
        'modified_date' => 'datetime',
    ];
}
