<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\BukuController;
use App\Http\Controllers\api\PeminjamanController;
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


    Route::get('/buku', [BukuController::class, 'index']);
    Route::get('/buku/{id}', [BukuController::class, 'show']);

    Route::get('/peminjaman', [PeminjamanController::class, 'index']);
    Route::post('/peminjaman/{id}', [PeminjamanController::class, 'store']);
    Route::get('/peminjaman/kembali/{id}', [PeminjamanController::class, 'kembali']);
});


    // Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    //     return $request->user();
    // });



