<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Models\Jurusan;
use Illuminate\Http\Request;

class SekolahController extends Controller
{
    public function index()
    {
        $sekolah = Sekolah::with('jurusan')
            ->when(request('nama'), fn($q) => $q->where('nama', 'like', '%' . request('nama') . '%'))
            ->paginate(10);
        return view('pages.sekolah.index', compact('sekolah'));
    }

    public function create()
    {
        return view('pages.sekolah.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'jurusan' => 'nullable|array',
            'jurusan.*' => 'required|string|max:255',
        ]);

        $sekolah = Sekolah::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
        ]);

        if ($request->jurusan) {
            foreach ($request->jurusan as $namaJurusan) {
                $sekolah->jurusan()->create([
                    'nama' => $namaJurusan,
                ]);
            }
        }

        return redirect()->route('sekolah.index')->with('success', 'Sekolah berhasil ditambahkan.');
    }

    public function edit(Sekolah $sekolah)
    {
        $sekolah->jurusan = json_decode($sekolah->jurusan, true);
        return view('pages.sekolah.edit', compact('sekolah'));
    }

    public function update(Request $request, Sekolah $sekolah)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'jurusan' => 'nullable|array',
            'jurusan.*.id' => 'nullable|integer|exists:jurusan,id',
            'jurusan.*.nama' => 'required|string|max:255',
        ]);

        $sekolah->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
        ]);

        // Hapus semua jurusan lama yang tidak ada di input
        $jurusanIds = collect($request->jurusan)->pluck('id')->filter();
        $sekolah->jurusan()->whereNotIn('id', $jurusanIds)->delete();

        foreach ($request->jurusan as $jurusan) {
            if (isset($jurusan['id'])) {
                // Update existing jurusan
                Jurusan::where('id', $jurusan['id'])->update([
                    'nama' => $jurusan['nama'],
                ]);
            } else {
                // Tambah jurusan baru
                $sekolah->jurusan()->create([
                    'nama' => $jurusan['nama'],
                ]);
            }
        }

        return redirect()->route('sekolah.index')->with('success', 'Sekolah berhasil diperbarui.');
    }

    public function destroy(Sekolah $sekolah)
    {
        $sekolah->jurusan()->delete();
        $sekolah->delete();

        return redirect()->route('sekolah.index')->with('success', 'Sekolah berhasil dihapus.');
    }
}
