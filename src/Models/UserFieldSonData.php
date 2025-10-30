<?php

namespace BabeRuka\ProfileHub\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFieldSonData extends Model
{
    use HasFactory;
    protected $table = 'user_field_son_data';
    protected $primaryKey = 'data_id';
    public $incrementing = true;
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'modified_date';

    protected $fillable = [
        'son_id',
        'data_key',
        'data_value',
        'data',
        'data_sequence',
        'create_date',
        'modified_date',
    ];

    protected $casts = [
        'data_id' => 'integer',
        'son_id' => 'integer',
        'create_date' => 'datetime',
        'modified_date' => 'datetime',
    ];
}
