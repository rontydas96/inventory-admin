<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function edit()
    {
        $setting = Setting::firstOrCreate(['id' => 1]);
        return view('settings.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = Setting::firstOrCreate(['id' => 1]);

        $validated = $request->validate([
            'brand_name' => ['required', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'gst_number' => ['nullable', 'string', 'max:100'],
            'pan_number' => ['nullable', 'string', 'max:100'],
            'address' => ['nullable', 'string'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'default_gst_percent' => ['required', 'numeric', 'min:0', 'max:100'],
            'bank_name' => ['nullable', 'string', 'max:255'],
            'bank_account_no' => ['nullable', 'string', 'max:255'],
            'bank_ifsc' => ['nullable', 'string', 'max:255'],
        ]);

        if ($request->hasFile('logo')) {
            // Delete old logo if present
            if ($setting->logo && Storage::disk('public')->exists($setting->logo)) {
                Storage::disk('public')->delete($setting->logo);
            }

            // Store new logo
            $validated['logo'] = $request->file('logo')
                ->store('logos', 'public');
        }

        $setting->update($validated);

        return redirect()
            ->route('settings.edit')
            ->with('success', 'Settings updated successfully.');
    }
}