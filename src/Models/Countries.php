<?php

namespace BabeRuka\ProfileHub\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
    use HasFactory;
    protected $table = 'countries';
    protected $primaryKey = 'country_id';
    public $incrementing = true;
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'modified_date';

    protected $fillable = [
        'country_name',
        'country_desc',
        'country_code',
        'dialing_code',
        'create_date',
        'modified_date',
    ];

    protected $casts = [
        'country_id' => 'integer',
        'create_date' => 'datetime',
        'modified_date' => 'datetime',
    ];
}
