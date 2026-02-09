<?php

use App\Http\Controllers\ArsipController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\AuthController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});
// authentication
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');



// ------------------------------------------------
// JANGAN DI HAPUS DULU
// Route::resource('surat_masuk', SuratMasukController::class);

// Route::get('/surat_keluar', [SuratKeluarController::class, 'index']);
// Route::resource('surat_keluar', SuratKeluarController::class);
// ------------------------------------------------

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/filter', [DashboardController::class, 'filter'])->name('dashboard.filter');

    Route::get('/arsip', function () {
        return view('arsip.index');
    });


    /** FITUR LAPORAN */
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.exportPdf');
    Route::get('/laporan/export-excel', [LaporanController::class, 'exportExcel'])->name('laporan.exportExcel');
    Route::get('/laporan/preview-excel', [LaporanController::class, 'previewExcel'])->name('laporan.previewExcel');

    /** FITUR MANAJEMEN PENGGUNA */
    Route::get('/manajemen-pengguna', [PenggunaController::class, 'index'])->name('pengguna.index');

    Route::get('/tambah-pengguna', [PenggunaController::class, 'create'])->name('pengguna.create');
    Route::post('/tambah-pengguna', [PenggunaController::class, 'store'])->name('pengguna.store');
    Route::get('/pengguna/{id}/edit', [PenggunaController::class, 'edit'])->name('pengguna.edit');
    Route::match(['put', 'patch', 'post'], '/pengguna/{id}', [PenggunaController::class, 'update'])->name('pengguna.update');
    Route::delete('/pengguna/{id}', [PenggunaController::class, 'destroy'])->name('pengguna.destroy');

    Route::get('/manajemen-pengguna', [PenggunaController::class, 'index'])
        ->name('pengguna.index');

    Route::get('/arsip', [ArsipController::class, 'index'])->name('arsip.index');
    Route::get('/arsip/upload', [ArsipController::class, 'create'])
        ->name('arsip.create');
    Route::post('/arsip/upload', [ArsipController::class, 'store'])
        ->name('arsip.store');
    Route::get('/arsip/download/{id}', [ArsipController::class, 'download'])
        ->name('arsip.download');
    Route::post('/arsip/bulk-download', [ArsipController::class, 'bulkDownload'])->name('arsip.bulkDownload');

    // surat masuk
    Route::get('/surat_masuk', [SuratMasukController::class, 'index'])
        ->name('surat_masuk.index');

    Route::get('/surat-masuk/search', [SuratMasukController::class, 'search'])
        ->name('surat_masuk.search');

    Route::post('/surat-masuk', [SuratMasukController::class, 'store'])
        ->name('surat-masuk.store');

    Route::get('/surat-masuk/create', [SuratMasukController::class, 'create'])
        ->name('surat-masuk.create');

    // surat keluar
    Route::get('/surat_keluar', [SuratKeluarController::class, 'index'])
        ->name('surat_keluar.index');

    Route::get('/surat_keluar/search', [SuratKeluarController::class, 'search'])
        ->name('surat_keluar.search');

    Route::post('/arsip/bulk-download', [ArsipController::class, 'bulkDownload']) ->name('arsip.bulkDownload');
});



// Route::get('/login', function () {
//     return view('auth.login');
// });
