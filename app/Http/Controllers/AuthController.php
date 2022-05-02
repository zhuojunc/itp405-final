<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $loginWasSuccessful = Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]);

        if ($loginWasSuccessful) {
            return redirect()->route('profile.index');
        } else {
            return redirect()->route('login')->with('error', 'Invalid credentials.');
        }
    }    

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }    
}
