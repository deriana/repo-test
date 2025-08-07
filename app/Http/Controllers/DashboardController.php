<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $totalUser = User::count();
        $totalHariIni = Attendance::whereDate('date', $today)->count();

        $seringTelat = Attendance::select('user_id', DB::raw('COUNT(*) as total_telat'))
            ->whereTime('time_in', '>', '08:00:00')
            ->groupBy('user_id')
            ->with('user')
            ->orderByDesc('total_telat')
            ->take(5)
            ->get();

        $tepatWaktu = Attendance::select('user_id', DB::raw('COUNT(*) as total_tepat'))
            ->whereTime('time_in', '<=', '08:00:00')
            ->groupBy('user_id')
            ->with('user')
            ->orderByDesc('total_tepat')
            ->take(5)
            ->get();

        return view('pages.dashboard', compact('totalUser', 'totalHariIni', 'seringTelat', 'tepatWaktu'));
    }
}
