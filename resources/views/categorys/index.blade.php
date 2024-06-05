@extends(Auth::user()->type == 'admin' ? 'layouts.app' : 'layouts.userp')
@push('css')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endpush

@section('content')
<div class="card-body">
                    {{-- <h3 class="text-center my-4">Daftar Kategori</h3>
                    <hr>
                </div>
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body"> --}}
                        <a href="{{ route(Auth::user()->type== 'admin' ? 'admin/categorys/create' : 'petugas/categorys/create') }}" class="btn btn-md btn-success mb-3">Tambah Kategori</a>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">NAMA KATEGORI</th>
                                        <th scope="col">DESKRIPSI</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($kategoris as $kategori)
                                        <tr>
                                            <td>{{ $kategori->nama_kategori }}</td>
                                            <td>
                                                {{ $kategori->deskripsi }}</td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route(Auth::user()->type== 'admin' ? 'admin/categorys/edit' : 'petugas/categorys/edit', $kategori->id) }}"
                                                        class="btn btn-sm btn-primary">Edit</a>
                                                    <form onsubmit="return confirm('Apakah Anda Yakin ?');"
                                                        action="{{ route(Auth::user()->type== 'admin' ? 'admin/categorys/destroy' : 'petugas/categorys/destroy', $kategori->id) }}" method="POST">
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
                </div>
            </div>
        </div>
    </div>
    @endsection
    @push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.
    @endpush
