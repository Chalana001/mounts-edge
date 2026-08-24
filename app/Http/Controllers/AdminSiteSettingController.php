<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminSiteSettingController extends Controller
{
    public function edit(): View
    {
        return view('admin.settings.edit', ['settings' => SiteSetting::current()]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'phone_display' => ['required', 'string', 'max:50'],
            'phone_link' => ['required', 'regex:/^\+[1-9][0-9]{6,14}$/'],
            'whatsapp_number' => ['required', 'regex:/^[1-9][0-9]{6,14}$/'],
            'public_email' => ['required', 'email', 'max:255'],
            'notification_email' => ['required', 'email', 'max:255'],
            'address' => ['required', 'string', 'max:500'],
            'map_url' => ['required', 'url:https', 'max:2000'],
        ]);

        SiteSetting::current()->update($validated);

        return back()->with('success', 'Site contact settings updated.');
    }
}
