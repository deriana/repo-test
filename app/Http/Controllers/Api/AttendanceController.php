<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // ✅ Tambahkan ini

class AttendanceController extends Controller
{
    // Menampilkan semua data absensi
    public function index(Request $request)
    {
        $attendances = Attendance::with('user')
            ->when($request->input('name'), function ($query, $name) {
                $query->whereHas('user', function ($query) use ($name) {
                    $query->where('name', 'like', '%' . $name . '%');
                });
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('pages.absensi.index', compact('attendances'));
    }

    // Menyimpan data absensi (Absen Masuk)
    public function store(Request $request)
    {
        $userId = Auth::id();
        $today = now()->toDateString();

        // Cek apakah user sudah absen masuk hari ini
        $alreadyAbsen = Attendance::where('user_id', $userId)
            ->where('date', $today)
            ->exists();

        if ($alreadyAbsen) {
            return redirect()->back()->with('error', '❌ Anda sudah melakukan absen masuk hari ini.');
        }

        // Simpan data absen
        Attendance::create([
            'user_id'   => $userId,
            'date'      => $today,
            'time_in'   => $request->time_in,
            'latlon_in' => $request->latlon_in,
        ]);

        return redirect()->route('attendances.index')->with('success', '✅ Absen berhasil dilakukan.');
    }
}
