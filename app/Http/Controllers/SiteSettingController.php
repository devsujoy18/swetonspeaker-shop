<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SiteSetting;

class SiteSettingController extends Controller
{
    public function edit()
    {
        $setting = SiteSetting::getSettings();
        return view('settings.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = SiteSetting::getSettings();

        $validated = $request->validate([
            'cart_enabled' => 'required|boolean',
            'minimum_cart_amount' => 'required|numeric|min:0',
            'cart_disabled_message' => 'nullable|string|max:255',
            'home_message' => 'nullable|string',
        ]);

        $setting->update($validated);

        return redirect()->back()->with('success', 'Settings updated successfully');
    }
}
