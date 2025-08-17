<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::with('user')->orderBy('id', 'desc');

        // Jika bukan admin, hanya tampilkan data user yang sedang login
        if (auth()->user()->role !== 'admin') {
            $query->where('user_id', auth()->id());
        }

        if ($request->input('name')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->input('name') . '%');
            });
        }

        $user = User::with(['sekolah', 'jurusan'])
            ->where('id', '!=', Auth::id())
            ->get();

        $attendances = $query->paginate(10);
        $permissions = Permission::where('user_id', auth()->id())
            ->where('date_permission', now()->toDateString())
            ->get();

            // dd($permissions);

        return view('pages.absensi.index', compact('attendances', 'user', 'permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'time_in' => 'required',
            'time_out' => 'nullable',
        ]);

        Attendance::create([
            'user_id' => $request->user_id,
            'date' => $request->date,
            'time_in' => $request->time_in,
            'time_out' => $request->time_out,
        ]);

        return redirect()->route('attendances.index')->with('success', 'Absensi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $attendance = Attendance::findOrFail($id);

        // Cegah user mengedit data milik orang lain (kecuali admin)
        if (auth()->user()->role !== 'admin' && $attendance->user_id !== auth()->id()) {
            abort(403);
        }

        return view('pages.absensi.edit', compact('attendance'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            // 'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'time_in' => 'required',
            'time_out' => 'nullable',
        ]);

        $attendance = Attendance::findOrFail($id);

        $attendance->update([
            // 'user_id' => $request->user_id,
            'date' => $request->date,
            'time_in' => $request->time_in,
            'time_out' => $request->time_out,
        ]);

        return redirect()->route('attendances.index')->with('success', 'Data absensi berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $attendance = Attendance::findOrFail($id);

        // Cegah user hapus data orang lain
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $attendance->delete();

        return redirect()->route('attendances.index')->with('success', 'Absen berhasil dihapus.');
    }
}
