<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'name',
        'mobile',
        'email',
        'gst_no',
        'address',
        'city',
        'state_id',
        'zip',
        'is_active'
    ];

    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
