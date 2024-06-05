@extends(Auth::user()->type == 'admin' ? 'layouts.app' : 'layouts.userp')
@push('css')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endpush

@section('content')
                    <div class="card-body">
                        <a href="{{ route(Auth::user()->type== 'admin' ? 'admin/publishers/create' : 'petugas/publishers/create') }}" class="btn btn-md btn-success mb-3">Tambah Penerbit</a>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">NAMA PENERBIT</th>
                                        <th scope="col">ALAMAT</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($penerbits as $penerbit)
                                        <tr>
                                            <td>{{ $penerbit->nama_penerbit }}</td>
                                            <td>
                                                {{ $penerbit->alamat }}</td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route(Auth::user()->type== 'admin' ? 'admin/publishers/edit' : 'petugas/publishers/edit', $penerbit->id) }}"
                                                        class="btn btn-sm btn-primary">Edit</a>
                                                    <form onsubmit="return confirm('Apakah Anda Yakin ?');"
                                                        action="{{ route(Auth::user()->type== 'admin' ? 'admin/publishers/destroy' : 'petugas/publishers/destroy', $penerbit->id) }}" method="POST">
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