<?php

namespace App\Http\Controllers;

use App\Models\buku;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('home');
    }

    public function adminHome(){
        $totalBooks = Buku::count();
        $totalUsers = User::count();

        return view('dashboard', compact('totalBooks', 'totalUsers'));
    }
    public function petugasHome(){
        return view('dashboardp');
    }

    
}
