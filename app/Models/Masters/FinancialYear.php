<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class FinancialYear extends Model
{
    protected $fillable = ['name', 'start_date', 'end_date', 'is_active'];
}
