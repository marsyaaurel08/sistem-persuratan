<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LaporanController;




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

// surat masuk
Route::get('/surat_masuk', function () {
    return view('surat_masuk.index');
});

// surat keluar
Route::get('/surat_keluar', function () {
    return view('surat_keluar.index');
});

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/arsip', function () {
    return view('arsip.index');
});


Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');


Route::get('/manajemen-pengguna', function () {
    return view('manajemen-pengguna.index');
});

Route::get('/tambah-pengguna', function () {
    return view('manajemen-pengguna.add-user');
});


Route::get('/upload_surat', function () {
    return view('surat_masuk.upload_surat');
});
Route::get('/login', function () {
    return view('auth.login');
});
