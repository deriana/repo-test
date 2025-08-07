<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Sekolah;
use App\Models\Jurusan;

class UserController extends Controller
{
    // Tampilkan daftar user (khusus admin)
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Khusus admin');
        }

        $users = User::where('name', 'like', '%' . request('name') . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('pages.users.index', compact('users'));
    }

    // Tampilkan form tambah user

    public function create()
    {
        $sekolah = Sekolah::all();
        return view('pages.users.create', compact('sekolah'));
    }


    // Simpan user baru
    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|min:8',
            'phone'      => 'nullable|string',
            'role'       => 'required|string',
            'sekolah_id' => 'required|exists:sekolah,id',
            'jurusan_id' => 'required|exists:jurusan,id',
            'image_url' => 'nullable|image|max:2048',

        ]);

        $imagePath = null;
        if ($request->hasFile('image_url')) {
            $imagePath = $request->file('image_url')->store('user-images', 'public');
        }

        User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'phone'       => $request->phone,
            'role'        => $request->role,
            'position'    => $request->position,
            'department'  => $request->department,
            'image_url'   => $imagePath, // ✅ pakai path yang disimpan, bukan file langsung
            'sekolah_id'  => $request->sekolah_id,
            'jurusan_id'  => $request->jurusan_id,
            'password'    => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil dibuat.');
    }


    // Tampilkan form edit user
    public function edit(User $user)
    {
        $sekolah = Sekolah::all();
        return view('pages.users.edit', compact('user', 'sekolah'));
    }

    // Update user
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'       => 'required',
            'email'      => 'required|email|unique:users,email,' . $user->id,
            'phone'      => 'nullable|string',
            'role'       => 'required|string',
            'sekolah_id' => 'nullable|exists:sekolah,id',
            'jurusan_id' => 'nullable|exists:jurusan,id',
            'image_url' => 'nullable|image|max:2048',
        ]);

        $data = $request->only([
            'name',
            'email',
            'phone',
            'role',
            'sekolah_id',
            'jurusan_id'
        ]);

        // Upload image jika ada
        if ($request->hasFile('image_url')) {
            $imagePath = $request->file('image_url')->store('user-images', 'public');
            $data['image_url'] = $imagePath;
        }

        // Update password jika diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User berhasil diupdate.');
    }


    // Hapus user
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }

    public function getJurusanBySekolah($id)
    {
        $jurusan = Jurusan::where('sekolah_id', $id)->pluck('nama', 'id');
        return response()->json($jurusan);
    }
}
