<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Update user avatar
     */
    public function updateAvatar(Request $request): RedirectResponse
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $path = $request->file('avatar')->store('avatars', 'public');
        $url = \Storage::url($path);

        $request->user()->update(['avatar' => $url]);

        return Redirect::route('profile.edit')->with('status', 'avatar-updated');
    }

    /**
     * Update password
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|confirmed|min:8',
        ]);

        $request->user()->update(['password' => bcrypt($validated['password'])]);

        return Redirect::route('profile.edit')->with('status', 'password-updated');
    }

    /**
     * Update notification & privacy preferences
     */
    public function updatePreferences(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'notification_email' => 'boolean',
            'notification_push' => 'boolean',
            'profile_privacy' => 'in:public,private',
            'default_post_privacy' => 'in:public,followers,private',
        ]);

        $request->user()->update($validated);

        return Redirect::route('profile.edit')->with('status', 'preferences-updated');
    }
}
