<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = ['name', 'code', 'is_active'];
}
