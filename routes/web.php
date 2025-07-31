<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();

// Route untuk admin (memiliki akses ke semua fitur)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin-dashboard', [App\Http\Controllers\DashboardController::class, 'admin'])->name('adminDashboard');
    // Fitur manajemen data
    Route::resource('kriteria', 'App\Http\Controllers\KriteriaController');
    Route::resource('alternatif', 'App\Http\Controllers\AlternatifController');
    Route::resource('crips', 'App\Http\Controllers\CripsController');
    Route::resource('user', 'App\Http\Controllers\UserController');
    Route::resource('penilaian', 'App\Http\Controllers\PenilaianController');
    Route::get('admin/user/admin', [App\Http\Controllers\UserController::class, 'admin'])->name('user.admin');
    Route::get('admin/warga-terpilih', [App\Http\Controllers\AlgoritmaController::class, 'index'])->name('warga-terpilih.index');
    Route::get('/laporan', function () {
        return view('admin.report.index');
    })->name('laporan');
    Route::get('admin/penerima', [App\Http\Controllers\LaporanController::class, 'wargaTerpilih'])->name('penerima');
    Route::get('/ajax/cari-alternatif', [App\Http\Controllers\AlternatifController::class, 'cariAlternatif'])->name('ajax.cari.alternatif');
    Route::get('/get-alternatif/{id}', [App\Http\Controllers\AlternatifController::class, 'getAlternatif']);


    Route::get('download-alternatif-pdf', [App\Http\Controllers\AlternatifController::class, 'downloadPDF']);
    Route::get('download-user-pdf', [App\Http\Controllers\UserController::class, 'downloadPDF']);
    Route::get('download-kriteria-pdf', [App\Http\Controllers\KriteriaController::class, 'downloadPDF']);
    Route::get('/download-crips-pdf/{id}', [App\Http\Controllers\KriteriaController::class, 'downloadCripsPDF']);
    Route::get('download-penilaian-pdf', [App\Http\Controllers\PenilaianController::class, 'downloadPDF']);
    Route::get('download-penilaian-detail-pdf/{id}', [App\Http\Controllers\PenilaianController::class, 'downloadPenilaianDetail'])->name('penilaian.downloadDetail');

    // Kalkulasi nilai
    Route::get('penilaian/calculate/{id}', [App\Http\Controllers\PenilaianController::class, 'calculate'])->name('penilaian.calculate');
    Route::get('penilaian/calculate-all', [App\Http\Controllers\PenilaianController::class, 'calculateAll'])->name('penilaian.calculateAll');
    Route::get('penilaian/calculate-saw', [App\Http\Controllers\PenilaianController::class, 'calculateAndProcessSAW'])->name('penilaian.calculateSAW');

    Route::get('/perhitungan/preview', [App\Http\Controllers\AlgoritmaController::class, 'previewPDF'])->name('perhitungan.preview');
});

// Route untuk kepala desa
Route::middleware(['auth', 'role:kepala_desa,admin'])->group(function () {
    Route::get('/dashboard-kepala-desa', [App\Http\Controllers\DashboardController::class, 'kepalaDesa'])->name('kepalaDesaDashboard');
    Route::get('/laporan', function () {
        return view('admin.report.index');
    })->name('laporan');
    Route::resource('/penilaian', 'App\Http\Controllers\PenilaianController');
    Route::get('kepala-desa/penerima', [App\Http\Controllers\LaporanController::class, 'wargaTerpilih'])->name('kepala.penerima');
    Route::get('/perhitungan', [App\Http\Controllers\AlgoritmaController::class, 'index'])->name('perhitungan.index');
    Route::get('download-perhitungan-pdf', [App\Http\Controllers\AlgoritmaController::class, 'downloadPDF']);
    Route::get('download-penilaian-pdf', [App\Http\Controllers\PenilaianController::class, 'downloadPDF'])->name('penilaian.downloadPDF');
    Route::get('download-penilaian-detail-pdf/{id}', [App\Http\Controllers\PenilaianController::class, 'downloadPenilaianDetail'])->name('penilaian.downloadDetail');
    Route::get('download-user-pdf', [App\Http\Controllers\UserController::class, 'downloadPDF']);
    Route::get('download-alternatif-pdf', [App\Http\Controllers\AlternatifController::class, 'downloadPDF']);
    Route::get('download-kriteria-pdf', [App\Http\Controllers\KriteriaController::class, 'downloadPDF']);

    // Kalkulasi nilai
    Route::get('penilaian/calculate/{id}', [App\Http\Controllers\PenilaianController::class, 'calculate'])->name('penilaian.calculate');
    Route::get('penilaian/calculate-all', [App\Http\Controllers\PenilaianController::class, 'calculateAll'])->name('penilaian.calculateAll');
    Route::get('penilaian/calculate-saw', [App\Http\Controllers\PenilaianController::class, 'calculateAndProcessSAW'])->name('penilaian.calculateSAW');

    // Route::get('/perhitungan/preview', [App\Http\Controllers\AlgoritmaController::class, 'previewPDF'])->name('perhitungan.preview');
});

// Route untuk semua user yang sudah login
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/dashboardusers', [App\Http\Controllers\DashboardController::class, 'user'])->name('userDashboard');
    Route::post('user/alternatifuser/create', [App\Http\Controllers\AlternatifController::class, 'create'])->name('alternatifuser.create');
    Route::get('user/alternatifuser/index', [App\Http\Controllers\AlternatifController::class, 'index'])->name('alternatifuser.index');

    Route::get('user/penilaianuser/index', [App\Http\Controllers\PenilaianController::class, 'indexUser'])->name('penilaianuser.index');
    Route::get('user/penilaianuser/create', [App\Http\Controllers\PenilaianController::class, 'createforuser'])->name('penilaianuser.create');
    Route::post('user/penilaianuser/store', [App\Http\Controllers\PenilaianController::class, 'storeUser'])->name('penilaianuser.store');
    Route::get('user/perhitungan/index', [App\Http\Controllers\AlgoritmaController::class, 'indexUser'])->name('perhitunganuser.index');
});

Route::get('/clear', function () {
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('route:cache');
    Artisan::call('config:cache');
    Artisan::call('optimize:clear');
    return 'Route cache cleared!';
})->name('call-artisan');
