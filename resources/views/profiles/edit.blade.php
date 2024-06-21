@extends('layouts.user')

@section('content')
<div class="container">
    <h1>Edit Profil</h1>
    <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Nama</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
        </div>


        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
    </form>
</div>
@endsection
