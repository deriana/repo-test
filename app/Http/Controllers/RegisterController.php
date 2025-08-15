<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        $sekolah = Sekolah::all();
        return view('pages.auth.register', compact('sekolah'));
    }


    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'sekolah_id' => 'nullable|exists:sekolah,id',
            'jurusan_id' => 'nullable|exists:jurusan,id',
        ]);

        $user = User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'sekolah_id' => $request->sekolah_id,
            'jurusan_id' => $request->jurusan_id,
        ]);


        // ✅ Auto-login setelah register
        auth()->login($user);

        // ✅ Redirect ke dashboard /home
        return redirect()->route('home')->with('success', 'Registrasi berhasil! Selamat datang.');
    }
}
