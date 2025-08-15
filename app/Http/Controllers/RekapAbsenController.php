<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Permission;
use Carbon\Carbon;

class RekapAbsenController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Khusus admin');
        }

        $tanggal_mulai = $request->input('tanggal_mulai');
        $tanggal_selesai = $request->input('tanggal_selesai');

        $query = Attendance::with('user');

        if ($tanggal_mulai && $tanggal_selesai) {
            $query->whereBetween('date', [$tanggal_mulai, $tanggal_selesai]);
        }

        $data = $query->orderBy('date', 'desc')->get();

        $summary = ['hadir' => 0, 'terlambat' => 0, 'izin' => 0];

        foreach ($data as $item) {
            $status = $item->status;

            if (!$status) {
                if ($item->time_in) {
                    $jam_masuk = Carbon::parse($item->time_in);
                    $status = $jam_masuk->gt(Carbon::createFromTime(8, 0, 0)) ? 'Terlambat' : 'Hadir';
                } else {
                    $status = '-';
                }
            }

            $item->status_terhitung = $status;

            if ($status === 'Hadir') $summary['hadir']++;
            elseif ($status === 'Terlambat') $summary['terlambat']++;
            elseif ($status === 'Izin') $summary['izin']++;
        }

        return view('rekap.index', compact('data', 'summary', 'tanggal_mulai', 'tanggal_selesai'));
    }

    public function tampil(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $tanggal_mulai = $request->tanggal_mulai;
        $tanggal_selesai = $request->tanggal_selesai;

        $query = Attendance::whereBetween('date', [$tanggal_mulai, $tanggal_selesai]);

        if (auth()->user()->role !== 'admin') {
            $query->where('user_id', auth()->id());
        } elseif ($request->nama) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->nama . '%');
            });
        }

        $data = $query->with('user')->get();

        $summary = ['hadir' => 0, 'terlambat' => 0, 'izin' => 0];

        foreach ($data as $item) {
            $status = $item->status;

            if (!$status) {
                if ($item->time_in) {
                    $jam_masuk = Carbon::parse($item->time_in);
                    $status = $jam_masuk->gt(Carbon::createFromTime(8, 0, 0)) ? 'Terlambat' : 'Hadir';
                } else {
                    $status = '-';
                }
            }

            $item->status_terhitung = $status;

            if ($status === 'Hadir') $summary['hadir']++;
            elseif ($status === 'Terlambat') $summary['terlambat']++;
            elseif ($status === 'Izin') $summary['izin']++;
        }

        return view('rekap.index', [
            'data' => $data,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_selesai' => $tanggal_selesai,
            'nama_input' => $request->nama ?? '',
            'summary' => $summary,
        ]);
    }

    public function izinIndex(Request $request)
    {
        $query = Permission::with('user');

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        $izinList = $query->latest()->get();

        $userId = auth()->id();
        $today = now()->toDateString();

        $sudahIzinHariIni = Permission::where('user_id', $userId)
            ->where('date_permission', $today)
            ->exists();

        return view('rekap.izin', compact('izinList', 'sudahIzinHariIni'));
    }

    public function izinStore(Request $request)
    {
        $userId = auth()->id();
        $today = now()->toDateString();

        $sudahIzin = Permission::where('user_id', $userId)
            ->where('date_permission', $today)
            ->exists();

        if ($sudahIzin) {
            return redirect()->route('home')->with('error', 'Kamu sudah mengajukan izin untuk hari ini.');
        }

        $data = $request->validate([
            'reason' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // dd($data);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('izin', 'public');
        }

        Permission::create([
            'user_id' => $userId,
            'date_permission' => $today,
            'reason' => $request->reason,
            'image' => $imagePath,
            'is_approved' => false,
        ]);

        return redirect()->route('attendances.index')->with('success', 'Izin berhasil diajukan.');
    }

    public function izinShow($id)
    {
        $izin = Permission::with('user')->findOrFail($id);
        return view('rekap.izin_detail', compact('izin'));
    }

    public function izinCreate()
    {
        return view('rekap.create');
    }
}
