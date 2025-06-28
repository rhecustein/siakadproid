<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::orderBy('group')->get();
        return view('settings.index', compact('settings'));
    }

    public function edit(Setting $setting)
    {
        return view('settings.edit', compact('setting'));
    }

    public function update(Request $request, Setting $setting)
    {
        $request->validate([
            'value' => 'nullable|string',
        ]);

        $setting->update([
            'value' => $request->value,
        ]);

        return redirect()->route('settings.index')->with('success', 'Setting updated.');
    }

    // Optional: disable creation/deletion
    public function create() { abort(403); }
    public function store(Request $request) { abort(403); }
    public function show(Setting $setting) { abort(403); }
    public function destroy(Setting $setting) { abort(403); }
}
