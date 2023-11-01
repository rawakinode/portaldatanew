<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.index');
    }

    public function authenticate(Request $request)
    {
        $LoginDataValidate = $request->validate([
            'username' => 'required|alpha_dash|string|max:255',
            'password' => 'required'
        ]);

        if (Auth::attempt($LoginDataValidate)) {
            $request->session()->regenerate();
 
            return redirect()->intended('/home/dashboard');
        }

        return redirect()->back()->withErrors('Failed to Login! Please check your username or password.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
 
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect('/auth/login');
    }
}
