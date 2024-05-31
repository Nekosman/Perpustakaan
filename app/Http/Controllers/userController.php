<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('user.index', compact('users'));
    }

    public function createAccount()
    {
        return view('user.createAccount');
    }

    public function store(Request $request) 
    {
        Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'type' => 'required|string|in:siswa,admin,petugas' 
        ])->validate();

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => $request->type,
            'is_approved' => $request->type == 'siswa' ? true : false 
        ]);

        return redirect()->route('admin.userlist')
            ->with('success', 'User created successfully.');
    }

    public function destroy(User $user)
    {
        $user->forceDelete();

        return redirect()->route('admin.userlist')
            ->with('success', 'user deleted successfully.');
    }
}
