<?php

namespace BabeRuka\ProfileHub\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageData extends Model
{
    use HasFactory;
    protected $table = 'page_data';
    protected $primaryKey = 'data_id';
    public $incrementing = true;
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'modified_date';

    protected $fillable = [
        'page_id',
        'page_key',
        'page_module',
        'page_sequence',
        'page_data',
        'create_date',
        'modified_date',
    ];

    protected $casts = [
        'data_id' => 'integer',
        'page_id' => 'integer',
        'page_sequence' => 'integer',
        'create_date' => 'datetime',
        'modified_date' => 'datetime',
    ];

    public function page()
    {
        return $this->belongsTo(Pages::class, 'page_id', 'page_id');
    }

}
