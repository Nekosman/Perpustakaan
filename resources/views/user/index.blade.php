@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>User list</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <a href="{{ route('admin.userlist.create') }}" class="btn btn-md btn-success mb-3">Tambah siswa</a>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Type</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->type }}</td>
                    <td class="text-center">
                        <div class="btn-group" role="group">
                        
                            <form onsubmit="return confirm('Apakah Anda Yakin ?');"
                                action="{{ route('admin.userlist.destroy', $user->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No users found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
