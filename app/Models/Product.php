<?php

namespace App\Models;

use App\Models\Masters\Category;
use App\Models\Masters\Gst;
use App\Models\Masters\Unit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

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

    public function getImageUrlAttribute()
    {
        return (!empty($this->image) && Storage::exists('products/' . $this->image))
            ? asset('storage/products/' . $this->image)
            : null;
    }

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

    public function purchaseItems()
    {
        return $this->hasMany(PurchaseItem::class);
    }

    public function purchaseReturnItems()
    {
        return $this->hasMany(PurchaseReturnItem::class);
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }

    public function saleReturnItems()
    {
        return $this->hasMany(SaleReturnItem::class);
    }
}
