<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    protected $fillable = [
        'purchase_id',
        'product_id',
        'price',
        'quantity',
        'sub_total',
        'discount',
        'gst_id',
        'gst_amount',
        'total',
    ];

    public function purchase()
    {
        return $this->belongsTo('Purchase');
    }

    public function product()
    {
        return $this->belongsTo('Product');
    }

    public function gst()
    {
        return $this->belongsTo('Gst');
    }
}
