<?php

namespace BabeRuka\ProfileHub\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountryDialingCodes extends Model
{
    use HasFactory;
    protected $table = 'country_dialing_codes';
    protected $primaryKey = 'country_id';
    public $incrementing = true;
}
