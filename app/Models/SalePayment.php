<?php

namespace App\Models;

use App\Models\Masters\PaymentMode;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class SalePayment extends Model
{
    protected $fillable = ['sale_id', 'payment_mode_id', 'date', 'amount'];

    protected function date(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value
                ? date('d-m-Y', strtotime($value))
                : null,

            set: fn ($value) => $value
                ? date('Y-m-d', strtotime($value))
                : null,
        );
    }

    public function paymentMode()
    {
        return $this->belongsTo(PaymentMode::class);
    }
}
