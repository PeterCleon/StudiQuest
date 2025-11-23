<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PlayerProfile;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'confirmed', 'min:8'],
            'password_confirmation' => ['required', 'string', 'min:8'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        PlayerProfile::create([
            'user_id' => $user->id,
            'level' => 1,
            'xp' => 0,
            'xp_needed' => 100,
            'history' => null,
        ]);


        return redirect()->route('login')->with('success', 'Success to create new user');
    }
}
