<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\TutorController;
use App\Http\Controllers\ReportController;

// Landing page
Route::get('/', function () {
    if (session('user')) {
        $role = session('user.role');
        return match ($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'siswa' => redirect()->route('siswa.dashboard'),
            'tutor' => redirect()->route('tutor.dashboard'),
            default => redirect()->route('login'),
        };
    }
    return view('landing');
})->name('home');

// Auth routes
Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',   [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register',[AuthController::class, 'register']);
Route::post('/logout',  [AuthController::class, 'logout'])->name('logout');

// Admin routes
Route::middleware(['brainova.auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard',           [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/kelola-tutor',        [AdminController::class, 'kelolaTutor'])->name('kelola-tutor');
    Route::post('/tutor/status',       [AdminController::class, 'updateTutorStatus'])->name('tutor.status');
    Route::post('/tutor/delete',       [AdminController::class, 'deleteTutor'])->name('tutor.delete');
    Route::get('/kelola-pembayaran',   [AdminController::class, 'kelolaPembayaran'])->name('kelola-pembayaran');
    Route::post('/pembayaran/update',  [AdminController::class, 'updatePembayaran'])->name('pembayaran.update');
    // Report routes
    Route::get('/report/pdf-pembayaran',  [ReportController::class, 'pdfPembayaran'])->name('report.pdf-pembayaran');
    Route::get('/report/pdf-booking',     [ReportController::class, 'pdfBooking'])->name('report.pdf-booking');
    Route::get('/report/excel-booking',   [ReportController::class, 'excelBooking'])->name('report.excel-booking');
    Route::get('/report/excel-pembayaran',[ReportController::class, 'excelPembayaran'])->name('report.excel-pembayaran');
});

// Siswa routes
Route::middleware(['brainova.auth:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard',    [SiswaController::class, 'dashboard'])->name('dashboard');
    Route::get('/cari-tutor',   [SiswaController::class, 'cariTutor'])->name('cari-tutor');
    Route::get('/tutor/{id}',   [SiswaController::class, 'tutorProfil'])->name('tutor-profil');
    Route::get('/jadwal',       [SiswaController::class, 'jadwalKelas'])->name('jadwal');
    Route::get('/pembayaran',   [SiswaController::class, 'pembayaran'])->name('pembayaran');
    Route::get('/ulasan',        [SiswaController::class, 'ulasan'])->name('ulasan');
    Route::post('/ulasan/store', [SiswaController::class, 'storeUlasan'])->name('ulasan.store');
    Route::get('/pesan',         [SiswaController::class, 'pesan'])->name('pesan');
    Route::post('/pesan/kirim',  [SiswaController::class, 'kirimPesan'])->name('pesan.kirim');
    Route::get('/pengaturan',    [SiswaController::class, 'pengaturan'])->name('pengaturan');
    Route::post('/pengaturan/profil',  [SiswaController::class, 'updateProfil'])->name('pengaturan.profil');
    Route::post('/pengaturan/sandi',   [SiswaController::class, 'updateSandi'])->name('pengaturan.sandi');
    Route::post('/checkout',    [SiswaController::class, 'checkout'])->name('checkout');
    Route::post('/booking',     [SiswaController::class, 'booking'])->name('booking');
    Route::get('/gateway/{id}', [SiswaController::class, 'gateway'])->name('gateway');
    Route::post('/gateway/{id}/confirm', [SiswaController::class, 'confirmPayment'])->name('gateway.confirm');
    Route::post('/booking/cancel', [SiswaController::class, 'cancelBooking'])->name('booking.cancel');
});

// Tutor routes
Route::middleware(['brainova.auth:tutor'])->prefix('tutor')->name('tutor.')->group(function () {
    Route::get('/dashboard',       [TutorController::class, 'dashboard'])->name('dashboard');
    Route::get('/profil',          [TutorController::class, 'profil'])->name('profil');
    Route::post('/profil/update',  [TutorController::class, 'updateProfil'])->name('profil.update');
    Route::get('/jadwal',          [TutorController::class, 'jadwal'])->name('jadwal');
    Route::post('/jadwal/create',  [TutorController::class, 'createJadwal'])->name('jadwal.create');
    Route::post('/jadwal/update',  [TutorController::class, 'updateJadwal'])->name('jadwal.update');
    Route::post('/jadwal/delete',  [TutorController::class, 'deleteJadwal'])->name('jadwal.delete');
    Route::get('/jadwal/toggle',   [TutorController::class, 'toggleStatusJadwal'])->name('jadwal.toggle');
    Route::post('/booking/status', [TutorController::class, 'updateStatusBooking'])->name('booking.status');
    Route::get('/pendapatan',      [TutorController::class, 'pendapatan'])->name('pendapatan');
    Route::get('/ulasan',          [TutorController::class, 'ulasan'])->name('ulasan');
    Route::get('/pesan',           [TutorController::class, 'pesan'])->name('pesan');
    Route::post('/pesan/kirim',    [TutorController::class, 'kirimPesan'])->name('pesan.kirim');
    Route::get('/pengaturan',      [TutorController::class, 'pengaturan'])->name('pengaturan');
    Route::post('/pengaturan/profil', [TutorController::class, 'updateProfilAkun'])->name('pengaturan.profil');
    Route::post('/pengaturan/sandi',  [TutorController::class, 'updateSandiAkun'])->name('pengaturan.sandi');
});
