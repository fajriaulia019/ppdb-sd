<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PendaftarController;
use App\Http\Controllers\AdminController;
      

Route::get('/', function () {
    return view('welcome'); 
});

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware(['role:calon_siswa'])->group(function () {
        Route::get('/pendaftaran', [PendaftarController::class, 'create'])->name('pendaftar.create');
        Route::post('/pendaftaran', [PendaftarController::class, 'store'])->name('pendaftar.store');
        Route::get('/pendaftaran/status', [PendaftarController::class, 'status'])->name('pendaftar.status');
        Route::get('/test', [PendaftarController::class, 'showTestPage'])->name('test.show'); 
        Route::post('/test/submit', [PendaftarController::class, 'submitTest'])->name('test.submit'); 
        Route::get('/test/review', [PendaftarController::class, 'showTestReview'])->name('pendaftar.test_review');
        Route::get('/daftar-ulang', [PendaftarController::class, 'showDaftarUlangForm'])->name('daftarulang.show');
        Route::post('/daftar-ulang', [PendaftarController::class, 'submitDaftarUlang'])->name('daftarulang.submit');
        Route::get('/cetak-bukti-pendaftaran', [PendaftarController::class, 'cetakBuktiPendaftaran'])->name('pendaftar.cetak_bukti');
    });

    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/pendaftar', [AdminController::class, 'listPendaftar'])->name('admin.pendaftar.index');
        Route::get('/pendaftar/{pendaftar}/edit', [AdminController::class, 'editPendaftar'])->name('admin.pendaftar.edit');
        Route::put('/pendaftar/{pendaftar}', [AdminController::class, 'updatePendaftar'])->name('admin.pendaftar.update');
        Route::post('/pendaftar/{pendaftar}/tolak', [AdminController::class, 'tolakPendaftar'])->name('admin.pendaftar.tolak');
        Route::delete('/pendaftar/{pendaftar}', [AdminController::class, 'destroyPendaftar'])->name('admin.pendaftar.destroy');
        Route::get('/test-results', [AdminController::class, 'listTestResults'])->name('admin.testresults.index');
        Route::get('/test-results/{testResult}/edit', [AdminController::class, 'editTestResult'])->name('admin.testresults.edit');
        Route::put('/test-results/{testResult}', [AdminController::class, 'updateTestResult'])->name('admin.testresults.update');
        Route::post('/pendaftar/{pendaftar}/verifikasi', [AdminController::class, 'verifikasiPendaftar'])->name('admin.pendaftar.verifikasi');
        Route::post('/pendaftar/{pendaftar}/batalkan-verifikasi', [AdminController::class, 'batalkanVerifikasiPendaftar'])->name('admin.pendaftar.batalkan-verifikasi');
        Route::get('/registered-students', [AdminController::class, 'listRegisteredStudents'])->name('admin.registered_students.index');
        Route::get('/registered-students/export', [AdminController::class, 'exportRegisteredStudents'])->name('admin.registered_students.export');
        
        Route::prefix('soal-ujian')->group(function () {
            Route::get('/', [AdminController::class, 'listSoalUjian'])->name('admin.soal_ujian.index');
            Route::get('/create', [AdminController::class, 'createSoalUjian'])->name('admin.soal_ujian.create');
            Route::post('/', [AdminController::class, 'storeSoalUjian'])->name('admin.soal_ujian.store');
            Route::get('/{soalUjian}/edit', [AdminController::class, 'editSoalUjian'])->name('admin.soal_ujian.edit');
            Route::put('/{soalUjian}', [AdminController::class, 'updateSoalUjian'])->name('admin.soal_ujian.update');
            Route::delete('/{soalUjian}', [AdminController::class, 'destroySoalUjian'])->name('admin.soal_ujian.destroy');
        });

        Route::prefix('periode-pendaftaran')->group(function () {
            Route::get('/', [AdminController::class, 'listPeriodePendaftaran'])->name('admin.periode_pendaftaran.index');
            Route::get('/create', [AdminController::class, 'createPeriodePendaftaran'])->name('admin.periode_pendaftaran.create');
            Route::post('/', [AdminController::class, 'storePeriodePendaftaran'])->name('admin.periode_pendaftaran.store');
            Route::get('/{periodePendaftaran}/edit', [AdminController::class, 'editPeriodePendaftaran'])->name('admin.periode_pendaftaran.edit');
            Route::put('/{periodePendaftaran}', [AdminController::class, 'updatePeriodePendaftaran'])->name('admin.periode_pendaftaran.update');
            Route::delete('/{periodePendaftaran}', [AdminController::class, 'destroyPeriodePendaftaran'])->name('admin.periode_pendaftaran.destroy');
        });
       
    });
});