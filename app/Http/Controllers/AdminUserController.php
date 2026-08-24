<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    public function index(): View
    {
        return view('admin.users.index', [
            'users' => User::latest()->paginate(15, ['*'], 'users_page')->withQueryString(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'email_verified_at' => now(),
            'password' => Hash::make($validated['password']),
        ]);
        $user->forceFill(['is_admin' => true])->save();

        return back()->with('success', 'Admin account created.');
    }

    public function updatePassword(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
            'remember_token' => null,
        ]);

        return back()->with('success', "Password updated for {$user->name}.");
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        $request->validate(['current_password' => ['required', 'current_password']]);

        if (User::where('is_admin', true)->count() <= 1) {
            return back()->withErrors(['user' => 'The final admin account cannot be deleted.']);
        }

        $isSelf = $request->user()->is($user);
        $user->delete();

        if ($isSelf) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->with('success', 'Your account has been deleted.');
        }

        return back()->with('success', 'Admin account deleted.');
    }
}
