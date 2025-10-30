<?php

namespace BabeRuka\ProfileHub\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountryCodes extends Model
{
    use HasFactory;
    protected $table = 'country_codes';
    protected $primaryKey = 'country_id';
    public $incrementing = true;
    protected $fillable = [
        'country_id',
        'country_code',
        'country_name',
        'country_currency_symbol',
        'country_currency_code',
        'country_currency',
    ];

    protected $casts = [
        'country_id' => 'integer',
    ];
}
