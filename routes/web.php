<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('main');
});


// Route::get('/surat-masuk', [SuratMasukController::class, 'index'])
//     ->name('surat-masuk.index');

