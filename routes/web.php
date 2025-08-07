<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LetterStatusController;
use App\Http\Controllers\RekapAbsenController;
use App\Http\Controllers\SekolahController;

// Halaman awal login
Route::get('/', function () {
    return view('pages.auth.auth-login');
});

// Semua yang butuh login:
Route::middleware(['auth'])->group(function () {
    // Ganti yang tadinya view langsung, jadi controller
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/home', [DashboardController::class, 'index'])->name('home');

    Route::resource('users', UserController::class);
    Route::resource('companies', CompanyController::class);
    Route::resource('attendances', AttendanceController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('sekolah', SekolahController::class);
Route::resource('letter-status', LetterStatusController::class);
});

// Registrasi
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::middleware(['auth'])->group(function () {
    Route::get('/rekap', [RekapAbsenController::class, 'index'])->name('rekap.index');
    Route::post('/rekap', [RekapAbsenController::class, 'tampil'])->name('rekap.tampil');
});

// Menampilkan form izin dan daftar izin
Route::get('/rekap/izin', [RekapAbsenController::class, 'izinIndex'])->name('rekap.izin');

// Menyimpan pengajuan izin
Route::post('/rekap/izin/store', [RekapAbsenController::class, 'izinStore'])->name('rekap.izin.store');

// Menampilkan detail izin
Route::get('/rekap/izin/{id}', [RekapAbsenController::class, 'izinShow'])->name('rekap.izin.show');
Route::get('/rekap/create', [RekapAbsenController::class, 'izinCreate'])->name('rekap.create');

Route::get('/company-profile', [CompanyController::class, 'showManual'])->name('company.manual');
Route::get('/profile', [CompanyController::class, 'show'])->name('company.show');
Route::get('/profile/edit', [CompanyController::class, 'edit'])->name('company.edit');
Route::post('/profile/update', [CompanyController::class, 'update'])->name('company.update');
Route::get('/get-jurusan-by-sekolah/{id}', [App\Http\Controllers\UserController::class, 'getJurusanBySekolah']);

