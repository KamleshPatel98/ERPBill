<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = ['name', 'short_name', 'is_active'];
}
