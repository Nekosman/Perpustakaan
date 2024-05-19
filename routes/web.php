<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BukuController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PenerbitController;
use App\Http\Controllers\PengarangController;
use App\Http\Controllers\PinjamController;
use App\Models\pengarang;

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

// Route::resource('buku', BukuController::class);
// Route::resource('kategori', KategoriController::class);
// Route::resource('penerbit', PenerbitController::class);
// Route::resource('pengarang', PengarangController::class);
// Route::resource('pinjam', PinjamController::class);


Route::get('/login', function () {
    return view('login');
});

Route::controller(AuthController::class)->group(function(){
    //register
    Route::get('register', 'register')->name('register');
    Route::post('register', 'registerSave')->name('register.save');

    //login
    Route::get('login', 'login')->name('login');
    Route::post('login', 'loginAction')->name('login.action');

    //logout
    Route::get('logout', 'logout')->middleware('auth')->name('logout');
});

Route::middleware(['auth', 'user-access:user'])->group(function(){
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

Route::middleware(['auth', 'user-access:admin'])->group(function(){
    Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('admin/home');
    
    Route::get('/admin/profile', [AdminController::class, 'profilepage'])->name('admin/profile');

   //books route
    Route::get('/admin/books', [BukuController::class, 'index'])->name('admin/books');
    Route::get('/admin/books/create', [BukuController::class, 'create'])->name('admin/books/create');
    Route::post('/admin/books', [BukuController::class, 'store'])->name('admin/books/store');
    Route::get('/admin/books/{buku}/edit', [BukuController::class, 'edit'])->name('admin/books/edit');
    Route::put('/admin/books/{buku}', [BukuController::class, 'update'])->name('admin/books/update');
    Route::delete('/admin/books/{buku}', [BukuController::class, 'destroy'])->name('admin/books/destroy');

    //categorys route
    Route::get('/admin/categorys', [KategoriController::class, 'index'])->name('admin/categorys');
    Route::get('/admin/categorys/create', [KategoriController::class, 'create'])->name('admin/categorys/create');
    Route::post('/admin/categorys', [KategoriController::class, 'store'])->name('admin/categorys/store');
    Route::get('/admin/categorys/{kategori}/edit', [KategoriController::class, 'edit'])->name('admin/categorys/edit');
    Route::put('/admin/categorys/{kategori}', [KategoriController::class, 'update'])->name('admin/categorys/update');
    Route::delete('/admin/categorys/{kategori}', [KategoriController::class, 'destroy'])->name('admin/categorys/destroy');

    //categorys route
    Route::get('/admin/authors', [PengarangController::class, 'index'])->name('admin/authors');
    Route::get('/admin/authors/create', [PengarangController::class, 'create'])->name('admin/authors/create');
    Route::post('/admin/authors', [PengarangController::class, 'store'])->name('admin/authors/store');
    Route::get('/admin/authors/{pengarang}/edit', [PengarangController::class, 'edit'])->name('admin/authors/edit');
    Route::put('/admin/authors/{pengarang}', [PengarangController::class, 'update'])->name('admin/authors/update');
    Route::delete('/admin/authors/{pengarang}', [PengarangController::class, 'destroy'])->name('admin/authors/destroy');

    //categorys route
    Route::get('/admin/publishers', [PenerbitController::class, 'index'])->name('admin/publishers');
    Route::get('/admin/publishers/create', [PenerbitController::class, 'create'])->name('admin/publishers/create');
    Route::post('/admin/publishers', [PenerbitController::class, 'store'])->name('admin/publishers/store');
    Route::get('/admin/publishers/{penerbit}/edit', [PenerbitController::class, 'edit'])->name('admin/publishers/edit');
    Route::put('/admin/publishers/{penerbit}', [PenerbitController::class, 'update'])->name('admin/publishers/update');
    Route::delete('/admin/publishers/{penerbit}', [PenerbitController::class, 'destroy'])->name('admin/publishers/destroy');
    // Route::get('/admin/buku/create', [BukuController::class, 'create'])->name('admin/buku.create');
    // Route::post('/admin/buku', [BukuController::class, 'store'])->name('admin/buku.store');
});

// Route::post('/login',);
