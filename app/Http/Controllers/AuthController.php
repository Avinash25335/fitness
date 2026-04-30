<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'age'      => ['required', 'integer', 'min:1', 'max:120'],
            'gender'   => ['required', 'string', 'in:male,female,other'],
            'height'   => ['required', 'numeric', 'min:50', 'max:300'],
            'weight'   => ['required', 'numeric', 'min:10', 'max:500'],
            // ── BUG 7 FIX: goal is now collected at registration ──
            'goal'     => ['nullable', 'in:weight_loss,muscle_gain,maintenance'],
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'user',
            'age'      => $request->age,
            'gender'   => $request->gender,
        ]);

        $heightMeters = $request->height / 100;
        $bmi = round($request->weight / ($heightMeters * $heightMeters), 2);

        $user->profile()->create([
            'height' => $request->height,
            'weight' => $request->weight,
            'bmi'    => $bmi,
            'goal'   => $request->goal, // ← now saved from registration form
        ]);

        Auth::login($user);

        return redirect('/dashboard')->with('success', 'Welcome to FitCore, ' . $user->name . '! 🎉');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
