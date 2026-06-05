<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{
    public function webData()
    {
        return view('panel.settings.web-data');
    }

    public function webDataUpdate(Request $request)
    {
        $validated = $request->validate([
            'app_name'          => 'required|string|max:255',
            'app_email'         => 'required|email|max:255',
            'app_phone'         => 'required|string|max:15',
            'app_alt_phone'     => 'nullable|string|max:15',
            'app_address'       => 'required|string|max:500',
            'app_footer_text'   => 'nullable|string|max:500',
            'page_limit'        => 'required|integer|min:1|max:250',
            'app_url'           => 'required|url|max:255',
        ]);

        $settingsData = [
            'app_name'        => $request->app_name,
            'app_email'       => $request->app_email,
            'app_phone'       => $request->app_phone,
            'app_alt_phone'   => $request->app_alt_phone,
            'app_address'     => $request->app_address,
            'app_footer_text' => $request->app_footer_text,
            'page_limit'      => $request->page_limit,
            'app_url'         => $request->app_url,
        ];

        foreach ($settingsData as $key => $value) {
            Setting::updateOrCreate(
                ['key_name' => $key],
                ['value' => $value]
            );

            Cache::forget('setting_' . $key);
        }

        return back()->with('success', 'Settings updated successfully');
    }
}
