<?php

namespace BabeRuka\ProfileHub\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountryStates extends Model
{
    use HasFactory;
    protected $table = 'country_states';
    protected $primaryKey = 'state_id';
    public $incrementing = true;
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'modified_date';

    protected $fillable = [
        'country_id',
        'state_name',
        'state_code',
        'state_capital',
        'state_region',
        'create_date',
        'modified_date',
    ];

    protected $casts = [
        'state_id' => 'integer',
        'country_id' => 'integer',
        'create_date' => 'datetime',
        'modified_date' => 'datetime',
    ];
}
