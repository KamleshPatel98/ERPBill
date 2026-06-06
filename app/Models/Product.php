<?php

namespace App\Models;

use App\Models\Masters\Category;
use App\Models\Masters\Gst;
use App\Models\Masters\Unit;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'category_id',
        'hsn_code',
        'unit_id',
        'gst_id',
        'mrp',
        'price',
        'image',
        'description',
        'opening_stock',
        'is_active',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function gst()
    {
        return $this->belongsTo(Gst::class);
    }
}
