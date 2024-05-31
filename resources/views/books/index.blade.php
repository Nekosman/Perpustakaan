@extends(Auth::user()->type == 'admin' ? 'layouts.app' : 'layouts.userp')
@push('css')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endpush

@section('content')
<div class="card-body">
    <a href="{{ route(Auth::user()->type == 'admin' ? 'admin/books/create' : 'petugas/books/create') }}" class="btn btn-md btn-success mb-3">Tambah Buku</a>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Gambar</th>
                    <th scope="col">Pinjam</th>
                    <th scope="col">Judul</th>
                    <th scope="col">Penerbit & Tahun Terbit</th>
                    <th scope="col">Pengarang</th>
                    <th scope="col">Stock</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($bukus as $buku)
                    <tr>
                        <td class="text-center">
                            <img src="{{ asset('/storage/bukus/'.$buku->image) }}" class="rounded"
                                style="max-width: 1500px">
                        </td>
                        <td><a href="" class="btn btn-flat btn-sm btn-warning">pinjam buku</a></td>
                        <td>{{ $buku->judul }}</td>
                        <td>
                            {{ $buku->penerbit->nama_penerbit }}<br>
                            {{ $buku->tahun_terbit }}
                        </td>
                        <td>{{ $buku->pengarang->nama_penulis }}</td>
                        <td>{{ $buku->stock }}</td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <a href="{{ route(Auth::user()->type == 'admin' ? 'admin/books/edit' : 'petugas/books/edit', $buku->id) }}"
                                    class="btn btn-sm btn-primary">Edit</a>
                                <form onsubmit="return confirm('Apakah Anda Yakin ?');"
                                    action="{{ route(Auth::user()->type == 'admin' ? 'admin/books/destroy' : 'petugas/books/destroy', $buku->id) }}" method="POST">
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
                        <td colspan="5" class="text-center">
                            <div class="alert alert-danger">
                                Data Buku belum Tersedia.
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
    {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4. --}}
