@extends(Auth::user()->type == 'admin' ? 'layouts.app' : 'layouts.userp')

@push('css')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endpush

@section('content')
<div class="card-body">
    <h3>Pengajuan Peminjaman Buku</h3>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Buku</th>
                    <th scope="col">User</th>
                    <th scope="col">Pengajuan</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $pinjam)
                    <tr>
                        <td>{{ $pinjam->id }}</td>
                        <td>{{ $pinjam->buku }}</td>
                        <td>{{ $pinjam->user }}</td>
                        <td>{{ $pinjam->pengajuan }}</td>
                        <td class="text-center">
                            @if ($pinjam->status == 'pengajuan')
                                <a href="{{ route('pinjam.accept', $pinjam->id) }}" class="btn btn-sm btn-success">Terima</a>
                                <a href="{{ route('pinjam.tolak', $pinjam->id) }}" class="btn btn-sm btn-danger">Tolak</a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">
                            <div class="alert alert-danger">
                                Data Pengajuan Peminjaman belum Tersedia.
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
@endpush
