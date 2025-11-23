<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:15',
            'bio' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Hanya siswa yang perlu validasi kelas, jurusan, nisn
        if ($user->role === 'siswa') {
            $studentValidated = $request->validate([
                'kelas' => 'nullable|in:X,XI,XII',
                'jurusan' => 'nullable|in:AKL,TKJ,BiD,OTKP,RPL,MM',
                'nisn' => 'nullable|string|max:20',
            ]);
            $validated = array_merge($validated, $studentValidated);
        }

        // Handle remove avatar
        if ($request->has('remove_avatar') && $request->remove_avatar == '1') {
            if ($user->avatar && Storage::exists('public/' . $user->avatar)) {
                Storage::delete('public/' . $user->avatar);
            }
            $validated['avatar'] = null;
        }

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::exists('public/' . $user->avatar)) {
                Storage::delete('public/' . $user->avatar);
            }
            
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $validated['avatar'] = $avatarPath;
        }

        $user->update($validated);

        return redirect()->route('profile.index')
                        ->with('success', 'Profile berhasil diperbarui!');
    }
}