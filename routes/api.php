<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\PeminjamanController;
use App\Http\Controllers\BukuController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'show']);

    Route::get('/buku', [BukuController::class, 'index']);
    
    // Rute-rute yang hanya bisa diakses oleh pengguna yang sudah login
    Route::post('/peminjaman/store/{id}', [PeminjamanController::class, 'store']);
    Route::post('/peminjaman/batal/{id}', [PeminjamanController::class, 'batal']);
    Route::post('/peminjaman/kembali/{id}', [PeminjamanController::class, 'kembali']);
    Route::get('/peminjaman/user', [PeminjamanController::class, 'peminjamanUser']);

    Route::get('/buku', [BukuController::class, 'index']);
    Route::get('/buku/{id}', [BukuController::class, 'show']);
    Route::post('/peminjaman', [PeminjamanController::class, 'index']);
});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



