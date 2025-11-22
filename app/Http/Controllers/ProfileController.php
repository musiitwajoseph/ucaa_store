<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use App\Models\Department;
use App\Models\JobTitle;
use App\Models\OfficeLocation;

class ProfileController extends Controller
{
    /**
     * Display the user's profile.
     */
    public function show()
    {
        $user = Auth::user()->load(['department', 'jobTitle', 'officeLocation', 'manager', 'roles.permissions']);
        
        return view('profile.show', compact('user'));
    }

    /**
     * Show the form for editing the user's profile.
     */
    public function edit()
    {
        $user = Auth::user()->load(['department', 'jobTitle', 'officeLocation']);
        $departments = Department::where('is_active', true)->orderBy('name')->get();
        $jobTitles = JobTitle::where('is_active', true)->orderBy('title')->get();
        $officeLocations = OfficeLocation::where('is_active', true)->orderBy('name')->get();
        
        return view('profile.edit', compact('user', 'departments', 'jobTitles', 'officeLocations'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'mobile' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'country' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'bio' => ['nullable', 'string', 'max:500'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'gender' => ['nullable', 'in:male,female,other'],
            'timezone' => ['nullable', 'string', 'max:50'],
            'locale' => ['nullable', 'string', 'max:10'],
        ]);

        $user->update($validated);

        return redirect()->route('profile.edit')
            ->with('success', 'Profile updated successfully.');
    }

    /**
     * Update the user's avatar.
     */
    public function updateAvatar(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'avatar' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        // Delete old avatar if exists
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Store new avatar
        $path = $request->file('avatar')->store('avatars', 'public');
        
        $user->update(['avatar' => $path]);

        return redirect()->route('profile.edit')
            ->with('success', 'Avatar updated successfully.');
    }

    /**
     * Remove the user's avatar.
     */
    public function removeAvatar()
    {
        $user = Auth::user();

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->update(['avatar' => null]);

        return redirect()->route('profile.edit')
            ->with('success', 'Avatar removed successfully.');
    }

    /**
     * Show the form for changing password.
     */
    public function security()
    {
        $user = Auth::user();
        
        return view('profile.security', compact('user'));
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        // Check if user is LDAP user
        if ($user->isLdapUser()) {
            return redirect()->route('profile.security')
                ->with('error', 'LDAP users cannot change password from this system. Please contact your system administrator.');
        }

        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('profile.security')
            ->with('success', 'Password changed successfully.');
    }

    /**
     * Show the user's account settings.
     */
    public function settings()
    {
        $user = Auth::user();
        
        return view('profile.settings', compact('user'));
    }

    /**
     * Update the user's account settings.
     */
    public function updateSettings(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'locale' => ['nullable', 'string', 'in:en,fr,es'],
            'timezone' => ['nullable', 'string', 'max:50'],
            'theme' => ['nullable', 'string', 'in:light,dark,auto'],
        ]);

        $user->update($validated);

        return redirect()->route('profile.settings')
            ->with('success', 'Settings updated successfully.');
    }
}
