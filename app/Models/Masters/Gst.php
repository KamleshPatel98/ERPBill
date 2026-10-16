<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class Gst extends Model
{
    protected $fillable = ['name', 'rate', 'is_active'];
}
