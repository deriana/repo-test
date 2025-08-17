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
        $validate = $request->validate([
            'name'       => 'required',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|min:8',
            'phone'      => 'nullable|string',
            'role'       => 'required|string',
            'sekolah'    => 'required|string|max:255',
            'jurusan'    => 'required|string|max:255',
            'image_url' => 'nullable|image|max:2048',
        ]);

        $sekolah = \App\Models\Sekolah::firstOrCreate(['nama' => $validate['sekolah']]);
        $jurusan = \App\Models\Jurusan::firstOrCreate([
            'nama'       => $validate['jurusan'],
            'sekolah_id' => $sekolah->id,
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
            'image_url'   => $imagePath,
            'sekolah_id' => $sekolah->id,
            'jurusan_id' => $jurusan->id,
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
        $validate = $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email,' . $user->id,
            'phone'      => 'nullable|string',
            'role'       => 'required|string',
            'sekolah'    => 'required|string|max:255',
            'jurusan'    => 'required|string|max:255',
            'password'   => 'nullable|min:8',
            'image_url'  => 'nullable|image|max:2048',
        ]);

        // Cari atau buat sekolah & jurusan
        $sekolah = \App\Models\Sekolah::firstOrCreate(['nama' => $validate['sekolah']]);
        $jurusan = \App\Models\Jurusan::firstOrCreate([
            'nama'       => $validate['jurusan'],
            'sekolah_id' => $sekolah->id,
        ]);

        // Siapkan data update
        $data = [
            'name'       => $validate['name'],
            'email'      => $validate['email'],
            'phone'      => $validate['phone'] ?? null,
            'role'       => $validate['role'],
            'sekolah_id' => $sekolah->id,
            'jurusan_id' => $jurusan->id,
        ];

        // Upload image jika ada
        if ($request->hasFile('image_url')) {
            $imagePath = $request->file('image_url')->store('user-images', 'public');
            $data['image_url'] = $imagePath;
        }

        // Update password jika diisi
        if (!empty($request->password)) {
            $data['password'] = Hash::make($request->password);
        }

        // Update user
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
