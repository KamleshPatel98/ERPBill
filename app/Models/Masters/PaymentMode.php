<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class PaymentMode extends Model
{
    protected $fillable = [
        'name',
        'is_active',
    ];
}
