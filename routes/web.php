<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BukuController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PenerbitController;
use App\Http\Controllers\PengarangController;
use App\Http\Controllers\PinjamController;
use App\Http\Controllers\userController;
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

Route::middleware(['auth', 'user-access:siswa'])->group(function(){
    Route::get('/siswa/home', [HomeController::class, 'index'])->name('siswa/home');
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

    //approval 
    Route::get('/admin/approvals', [ApprovalController::class, 'index'])->name('admin.approvals');
    Route::post('/admin/approvals/{id}/approve', [ApprovalController::class, 'approve'])->name('admin.approvals.approve');

    //list user
    Route::get('/admin/userlist', [userController::class, 'index'])->name('admin.userlist');
    Route::get('/admin/userlist/create', [userController::class, 'createAccount'])->name('admin.userlist.create');
    Route::post('/admin/userlist', [userController::class, 'store'])->name('admin.userlist.store');
    Route::delete('/admin/userlist/{user}', [userController::class, 'destroy'])->name('admin.userlist.destroy');
    // Route::get('/admin/buku/create', [BukuController::class, 'create'])->name('admin/buku.create');
    // Route::post('/admin/buku', [BukuController::class, 'store'])->name('admin/buku.store');

    Route::get('pinjam-buku/{id}', [PinjamController::class, 'index'])->name('admin.peminjaman-buku');
});

Route::middleware(['auth', 'user-access:petugas'])->group(function(){
    Route::get('/petugas/home', [HomeController::class, 'petugasHome'])->name('petugas/home');

    //books route
    Route::get('/petugas/books', [BukuController::class, 'index'])->name('petugas/books');
    Route::get('/petugas/books/create', [BukuController::class, 'create'])->name('petugas/books/create');
    Route::post('/petugas/books', [BukuController::class, 'store'])->name('petugas/books/store');
    Route::get('/petugas/books/{buku}/edit', [BukuController::class, 'edit'])->name('petugas/books/edit');
    Route::put('/petugas/books/{buku}', [BukuController::class, 'update'])->name('petugas/books/update');
    Route::delete('/petugas/books/{buku}', [BukuController::class, 'destroy'])->name('petugas/books/destroy');

    //categorys route
    Route::get('/petugas/categorys', [KategoriController::class, 'index'])->name('petugas/categorys');
    Route::get('/petugas/categorys/create', [KategoriController::class, 'create'])->name('petugas/categorys/create');
    Route::post('/petugas/categorys', [KategoriController::class, 'store'])->name('petugas/categorys/store');
    Route::get('/petugas/categorys/{kategori}/edit', [KategoriController::class, 'edit'])->name('petugas/categorys/edit');
    Route::put('/petugas/categorys/{kategori}', [KategoriController::class, 'update'])->name('petugas/categorys/update');
    Route::delete('/petugas/categorys/{kategori}', [KategoriController::class, 'destroy'])->name('petugas/categorys/destroy');

    //categorys route
    Route::get('/petugas/authors', [PengarangController::class, 'index'])->name('petugas/authors');
    Route::get('/petugas/authors/create', [PengarangController::class, 'create'])->name('petugas/authors/create');
    Route::post('/petugas/authors', [PengarangController::class, 'store'])->name('petugas/authors/store');
    Route::get('/petugas/authors/{pengarang}/edit', [PengarangController::class, 'edit'])->name('petugas/authors/edit');
    Route::put('/petugas/authors/{pengarang}', [PengarangController::class, 'update'])->name('petugas/authors/update');
    Route::delete('/petugas/authors/{pengarang}', [PengarangController::class, 'destroy'])->name('petugas/authors/destroy');

    //categorys route
    Route::get('/petugas/publishers', [PenerbitController::class, 'index'])->name('petugas/publishers');
    Route::get('/petugas/publishers/create', [PenerbitController::class, 'create'])->name('petugas/publishers/create');
    Route::post('/petugas/publishers', [PenerbitController::class, 'store'])->name('petugas/publishers/store');
    Route::get('/petugas/publishers/{penerbit}/edit', [PenerbitController::class, 'edit'])->name('petugas/publishers/edit');
    Route::put('/petugas/publishers/{penerbit}', [PenerbitController::class, 'update'])->name('petugas/publishers/update');
    Route::delete('/petugas/publishers/{penerbit}', [PenerbitController::class, 'destroy'])->name('petugas/publishers/destroy');
    
});
// Route::post('/login',);
