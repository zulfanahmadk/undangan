<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Show login form
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $loginInput = $request->validate([
            'login' => 'required|string',
            'password' => 'required',
        ]);

        // Determine if input is email or username
        $isEmail = filter_var($loginInput['login'], FILTER_VALIDATE_EMAIL);

        // Try to authenticate with email first if input looks like email, otherwise try username
        if ($isEmail) {
            $credentials = [
                'email' => $loginInput['login'],
                'password' => $loginInput['password'],
            ];
        } else {
            $credentials = [
                'username' => $loginInput['login'],
                'password' => $loginInput['password'],
            ];
        }

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'login' => 'Username/Email atau password salah.',
        ])->onlyInput('login');
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
