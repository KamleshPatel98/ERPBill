<?php

namespace App\Models;

use App\Models\Masters\Gst;
use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    protected $fillable = [
        'sale_id',
        'product_id',
        'price',
        'quantity',
        'sub_total',
        'discount',
        'gst_id',
        'gst_rate',
        'gst_amount',
        'total',
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function gst()
    {
        return $this->belongsTo(Gst::class);
    }
}
