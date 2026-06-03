<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

if (!function_exists("getSetting")) { 
    function getSetting($key) // mobile, email
    {
        return Cache::rememberForever('setting_' . $key, function () use ($key) {
            return Setting::where('key_name', $key)->value('value');
        });
    }
}