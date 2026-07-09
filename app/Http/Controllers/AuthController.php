<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Display the login page.
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle user login. Supports password or mock OTP verification.
     */
    public function login(Request $request)
    {
        // For OTP code login
        if ($request->has('otp')) {
            $request->validate([
                'phone' => 'required',
                'otp_code' => 'required|numeric'
            ]);

            // Validate that the user entered the simulated OTP code (1234 is the default mock code)
            if ($request->otp_code == '1234') {
                $user = User::where('phone', $request->phone)->first();
                if ($user) {
                    Auth::login($user);
                    return redirect()->intended('/')->with('success', 'Logged in successfully via Phone OTP!');
                }
                return back()->withErrors(['phone' => 'Phone number not registered. Please register first.']);
            }
            return back()->withErrors(['otp_code' => 'Invalid OTP code. Use 1234 for simulation.']);
        }

        // Standard Email/Password Login
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Redirect based on role
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'landlord') {
                return redirect()->route('landlord.dashboard');
            }
            return redirect()->intended('/')->with('success', 'Welcome back, ' . $user->name . '!');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Display the registration page.
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Handle user registration.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20|unique:users',
            'role' => 'required|in:tenant,landlord',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'password' => Hash::make($request->password),
            'is_verified' => true, // Auto-verify phone number on registration for MVP ease
        ]);

        Auth::login($user);

        // Redirect based on role
        if ($user->role === 'landlord') {
            return redirect()->route('landlord.dashboard')->with('success', 'Registration successful! Welcome to your dashboard.');
        }
        return redirect()->to('/')->with('success', 'Registration successful! Welcome to AccraRent.');
    }

    /**
     * Handle user logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Logged out successfully.');
    }
}
