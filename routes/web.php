<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BukuController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PenerbitController;
use App\Http\Controllers\PengarangController;

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
    return view('welcome');
});

Route::resource('buku', BukuController::class);
Route::resource('kategori', KategoriController::class);
Route::resource('penerbit', PenerbitController::class);
Route::resource('pengarang', PengarangController::class);

