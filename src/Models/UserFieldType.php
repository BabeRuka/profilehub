<?php

namespace BabeRuka\ProfileHub\Models;

use Illuminate\Database\Eloquent\Model;

class UserFieldType extends Model
{
    protected $table = 'user_field_type';
    protected $primaryKey = 'type_id';
    public $incrementing = true;
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'modified_date';

    protected $fillable = [
        'type_field',
        'type_file',
        'type_class',
        'type_category',
        'create_date',
        'modified_date',
    ];

    protected $casts = [
        'type_id' => 'integer',
        'create_date' => 'datetime',
        'modified_date' => 'datetime',
    ];
}
