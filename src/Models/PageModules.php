<?php

namespace BabeRuka\ProfileHub\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageModules extends Model
{
    use HasFactory;
    protected $table = 'page_modules';
    protected $primaryKey = 'module_id';
    public $incrementing = true;
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'modified_date';

    protected $fillable = [
        'page_id',
        'group_id',
        'setting_id',
        'has_widget',
        'widget_order',
        'widget_type',
        'module_name',
        'mudule_slug',
        'module_icon',
        'module_desc',
        'module_active',
        'create_date',
        'modified_date',
    ];

    protected $casts = [
        'module_id' => 'integer',
        'page_id' => 'integer',
        'group_id' => 'integer',
        'widget_order' => 'integer',
        'create_date' => 'datetime',
        'modified_date' => 'datetime',
    ];

    public function page()
    {
        return $this->belongsTo(Pages::class, 'page_id', 'page_id');
    }

    public function group()
    {
        return $this->belongsTo(PageModuleGroups::class, 'group_id', 'group_id');
    }
}
