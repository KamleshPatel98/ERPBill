<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class FinancialYear extends Model
{
    protected $fillable = ['name', 'start_date', 'end_date', 'is_active'];

    protected function startDate(): Attribute
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

    protected function endDate(): Attribute
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
}
