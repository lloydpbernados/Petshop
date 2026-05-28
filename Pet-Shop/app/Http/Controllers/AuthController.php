<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Show the login page (fallback for direct access).
     */
    /**
     * Show the login page (fallback for direct access).
     */
    public function showLogin()
    {
        if (Auth::check()) {
            // Use direct route redirects here instead of intended
            return Auth::user()->role === 'admin' 
                ? redirect()->route('admin.dashboard') 
                : redirect()->route('shop');
        }
        
        return redirect('/')->with('show_login', true);
    }

    /**
     * Handle login form submission.
     */
    public function login(Request $request)
{
    $credentials = $request->validate([
        'email'    => ['required', 'email', 'max:255'],
        'password' => ['required', 'min:6'],
    ], [
        'email.required'    => 'Please enter your email address.',
        'email.email'       => 'Please enter a valid email address.',
        'password.required' => 'Please enter your password.',
        'password.min'      => 'Password must be at least 6 characters.',
    ]);

   if (Auth::attempt($credentials, $request->boolean('remember'))) {
    $request->session()->regenerate();

    /** @var \App\Models\User $user */
    $user = Auth::user(); // ✅ Already fresh after attempt — no ->fresh() needed

    $isAdmin     = $user && $user->role === 'admin';
    $redirectUrl = $isAdmin ? route('admin.dashboard') : route('shop');

    if ($request->ajax() || $request->wantsJson()) {
        return response()->json([
            'success'  => true,
            'message'  => 'Authenticated successfully! 🐾',
            'redirect' => $redirectUrl,
            'user'     => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
                'role'  => $user->role,
            ],
        ], 200);
    }

    return $isAdmin
        ? redirect()->route('admin.dashboard')->with('success', 'Welcome back, Admin! 🐾')
        : redirect()->intended(route('shop'))->with('success', 'Welcome back! 🐾');
}
    if ($request->ajax() || $request->wantsJson()) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid credentials. Please check your email and password.',
            'errors'  => ['email' => ['These credentials do not match our records.']],
        ], 422);
    }

    return back()
        ->withErrors(['email' => 'These credentials do not match our records.'])
        ->withInput($request->only('email'))
        ->with('show_login', true);
}

    /**
     * Show the registration page (fallback for direct access).
     */
    public function showRegister()
    {
        if (Auth::check()) {
            return Auth::user()->role === 'admin' 
                ? redirect()->intended(route('admin.dashboard')) 
                : redirect()->intended(route('shop'));
        }
        
        // Redirect to the home page where your modal is
        return redirect('/')->with('show_register', true);
    }

    /**
     * Handle registration form submission.
     */
    public function register(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'min:2'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'min:8', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).+$/'],
        ], [
            'name.required' => 'Please enter your full name.',
            'name.min' => 'Name must be at least 2 characters.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered. Try logging in instead.',
            'password.required' => 'Please create a password.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Passwords do not match.',
            'password.regex' => 'Password must include uppercase, lowercase, a number, and a special character.',
        ]);

        // Create the user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'customer',
        ]);


        // AJAX Request: Return JSON response
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Account created! Please log in to continue. 🎉',
                'redirect' => false, // Sends them back to the welcome page to log in
            ], 201);
        }

        // Traditional Request: Redirect to home with login trigger
        return redirect('/')->with('show_login', true)->with('success', 'Account created! Please log in.');
    }

    /**
     * Handle logout.
     */
    public function logout(Request $request)
    {
        $userName = Auth::user()?->name ?? 'User';
        
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'You have been logged out.',
                'redirect' => route('home') 
            ]);
        }

        return redirect('/')->with('success', 'You have been logged out, ' . $userName . '. Come back soon! 🐾');
    }
}