<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthWebController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        if (!auth()->attempt($request->only('email', 'password'))) {
            return back();
        }
        return redirect('/dashboard');
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/');
    }
}
