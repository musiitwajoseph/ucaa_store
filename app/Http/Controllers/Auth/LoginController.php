<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class LoginController extends Controller
{
    /**
     * Display the login view.
     */
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an authentication attempt.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Determine if input is email or username
        $loginField = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        
        $remember = $request->boolean('remember');

        // Try LDAP authentication first (with error handling)
        try {
            if (Auth::attempt([$loginField => $credentials['email'], 'password' => $credentials['password']], $remember)) {
                $request->session()->regenerate();
                
                // Update last login information
                $user = Auth::user();
                $user->updateLastLogin($request->ip());
                
                return redirect()->intended(route('dashboard'))->with('success', 'Welcome back, ' . $user->name . '!');
            }
        } catch (\LdapRecord\LdapRecordException $e) {
            // Log LDAP error but continue to fallback authentication
            \Log::warning('LDAP authentication failed: ' . $e->getMessage());
        } catch (\Exception $e) {
            // Log any other authentication errors
            \Log::error('Authentication error: ' . $e->getMessage());
        }

        // If LDAP fails or is unavailable, try local authentication for non-LDAP users
        $user = User::where($loginField, $credentials['email'])->first();
        
        if ($user && !$user->is_ldap_user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user, $remember);
            $request->session()->regenerate();
            
            $user->updateLastLogin($request->ip());
            
            return redirect()->intended(route('dashboard'))->with('success', 'Welcome back, ' . $user->name . '!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'You have been logged out successfully.');
    }

    /**
     * Show the profile page.
     */
    public function profile(): View
    {
        return view('auth.profile', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Update the user's profile.
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'first_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'mobile' => ['nullable', 'string', 'max:20'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'timezone' => ['nullable', 'string', 'max:50'],
            'locale' => ['nullable', 'string', 'max:10'],
            'theme' => ['nullable', 'string', 'in:light,dark,auto'],
        ]);

        // Don't allow LDAP users to update certain fields
        if ($user->is_ldap_user) {
            unset($validated['first_name'], $validated['last_name']);
        }

        $user->update($validated);

        return back()->with('success', 'Profile updated successfully.');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $user = Auth::user();

        // LDAP users cannot change password locally
        if ($user->is_ldap_user) {
            return back()->withErrors([
                'password' => 'LDAP users must change their password through the directory service.',
            ]);
        }

        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('success', 'Password updated successfully.');
    }
}
