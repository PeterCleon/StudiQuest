<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string']
        ]);

        if (\Illuminate\Support\Facades\Auth::attempt($request->only(['email', 'password']))) {
            $request->session()->regenerate();
            return redirect()->route('dashboard')->with('success', 'Success to login');
        }

        return back()->withErrors([
            'email' => 'Email or password not valid'
        ]);


    }
}
