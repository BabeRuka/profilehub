<?php

namespace BabeRuka\ProfileHub\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    use HasFactory;

    protected $table = 'pages';
    protected $primaryKey = 'page_id';
    public $incrementing = true;
    const CREATED_AT = 'create_date';
    const UPDATED_AT = 'modified_date';

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'page_slug',
        'page_name',
        'page_title',
        'page_tags',
        'page_type',
        'page_admin',
        'page_desc',
        'page_content',
        'linked_page',
        'page_settings',
        'create_date',
        'modified_date',
    ];

    /**
     * Attribute casting
     */
    protected $casts = [
        'page_id' => 'integer',
        'page_type' => 'integer',
        'page_admin' => 'integer',
        'create_date' => 'datetime',
        'modified_date' => 'datetime',
    ];

    public function pageData()
    {
        return $this->hasMany(PageData::class, 'page_id', 'page_id');
    }

    public function modules()
    {
        return $this->hasMany(PageModules::class, 'page_id', 'page_id');
    }

    public function widgets()
    {
        return $this->hasMany(PageWidgets::class, 'page_id', 'page_id');
    }

}
