<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

if (!function_exists("getSetting")) { 
    function getSetting($key) // mobile, email
    {
        return Cache::rememberForever('setting_' . $key, function () use ($key) {
            return Setting::where('key_name', $key)->value('value');
        });
    }
}

if (!function_exists("uploadFile"))
{
    function uploadFile($file, $path)
    {   
        if (!$file) {
            return null;
        }
        $filename = date('YmdHis') . '_' . rand(1111, 9999) . '.' . $file->getClientOriginalExtension();
        $file->storeAs($path, $filename);
        return $filename;
    }
}

if (!function_exists("deleteFile")) {
    function deleteFile($filename, $path)
    {
        if (!empty($filename) && Storage::exists($path . $filename)) {
            Storage::delete($path . $filename);
        }
    }
}

if (!function_exists('generateNo')) {
    function generateNo($model, $prefix)
    {
        $className = "App\\Models\\{$model}";
        $lastRecord = $className::latest('id')->first();
        $nextNumber = $lastRecord ? ($lastRecord->id + 1) : 1;
        return $prefix . '-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
    }
}