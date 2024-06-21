@extends('layouts.user')

@section('content')
<div class="container mx-auto my-8 p-4">
    <h1 class="text-2xl font-bold mb-4">Profil Saya</h1>
    <div class="mb-6">
        <p class="mb-2">Nama: {{ $user->name }}</p>
        <p class="mb-2">Email: {{ $user->email }}</p>
        <p class="mb-2">Role: {{ $user->type }}</p>
    </div>
    <a href="{{ route('profile.edit') }}" class="btn btn-primary bg-blue-500 text-white py-2 px-4 rounded">Edit Profil</a>
</div>
@endsection
