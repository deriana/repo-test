<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Disposition;
use App\Models\Letter;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $totalUser = User::count();
        $totalHariIni = Attendance::whereDate('date', $today)->count();

        $today = now()->toDateString();
        $yesterday = now()->subDay()->toDateString();

        $todayIncomingLetter = Letter::countIncomingByDate($today);
        $todayOutgoingLetter = Letter::countOutgoingByDate($today);
        $todayDispositionLetter = Disposition::countByDate($today);
        $todayLetterTransaction = $todayIncomingLetter + $todayOutgoingLetter + $todayDispositionLetter;

        $yesterdayIncomingLetter = Letter::countIncomingByDate($yesterday);
        $yesterdayOutgoingLetter = Letter::countOutgoingByDate($yesterday);
        $yesterdayDispositionLetter = Disposition::countByDate($yesterday);
        $yesterdayLetterTransaction = $yesterdayIncomingLetter + $yesterdayOutgoingLetter + $yesterdayDispositionLetter;

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

        return view('pages.dashboard', compact(
            'totalUser',
            'totalHariIni',
            'seringTelat',
            'tepatWaktu',
            'todayIncomingLetter',
            'todayOutgoingLetter',
            'todayDispositionLetter',
            'todayLetterTransaction',
            'yesterdayIncomingLetter',
            'yesterdayOutgoingLetter',
            'yesterdayDispositionLetter',
            'yesterdayLetterTransaction',
        ));
    }
}
