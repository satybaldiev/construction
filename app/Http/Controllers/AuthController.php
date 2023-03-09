<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function postLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard');
        }
        return redirect()->back()->withErrors(['email' => 'Invalid credentials'])->withInput($request->only('email'));
    }
}
