<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name', 'mobile', 'address', 'is_active'];
}
