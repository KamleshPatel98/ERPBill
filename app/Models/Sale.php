<?php

namespace App\Models;

use App\Models\Masters\Customer;
use App\Models\Masters\FinancialYear;
use App\Models\Masters\PaymentMode;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'invoice_no',
        'invoice_date',
        'customer_id',
        'financial_year_id',
        'payment_mode_id',
        'payment_status',
        'grand_amount',
        'gst_amount',
        'discount_amount',
        'total_amount',
        'paid_amount',
        'due_amount',
        'notes',
    ];

    protected function invoiceDate(): Attribute
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

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function financialYear()
    {
        return $this->belongsTo(FinancialYear::class);
    }

    public function paymentMode()
    {
        return $this->belongsTo(PaymentMode::class);
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }
}
