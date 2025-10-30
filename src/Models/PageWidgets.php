<?php

namespace BabeRuka\ProfileHub\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageWidgets extends Model
{
    use HasFactory;
    protected $table = 'page_widgets';
    protected $primaryKey = 'widget_id';
    public $incrementing = true;
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'modified_date';

    protected $fillable = [
        'page_id',
        'page_key',
        'widget_key',
        'widget_value',
        'widget_active',
        'widget_order',
        'create_date',
        'modified_date',
    ];

    protected $casts = [
        'widget_id' => 'integer',
        'page_id' => 'integer',
        'widget_order' => 'integer',
        'create_date' => 'datetime',
        'modified_date' => 'datetime',
    ];

    public function page()
    {
        return $this->belongsTo(Pages::class, 'page_id', 'page_id');
    }
}
