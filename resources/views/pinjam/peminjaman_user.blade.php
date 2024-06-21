@extends('layouts.user')

@push('css')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endpush

@section('content')
<div class="card-body">
    <h3>Daftar Peminjaman Saya</h3>
    <div class="mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Cari berdasarkan judul buku">
    </div>
    <div class="table-responsive">
        <table class="table table-bordered" id="peminjamanTable">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Buku</th>
                    <th scope="col">Pengajuan</th>
                    <th scope="col">Tanggal Peminjaman</th>
                    <th scope="col">Tanggal Pengembalian</th>
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $pinjam)
                    <tr>
                        <td>{{ $pinjam->id }}</td>
                        <td>{{ $pinjam->bukus->judul }}</td>
                        <td>{{ $pinjam->pengajuan }}</td>
                        <td>{{ $pinjam->tanggal_peminjaman }}</td>
                        <td>{{ $pinjam->tanggal_pengembalian }}</td>
                        <td>{{ $pinjam->status }}</td>
                        <td> 
                            @if($pinjam->status === 'pengajuan')
                                <form action="{{ route('peminjaman.batal', $pinjam->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Batalkan Peminjaman</button>
                                </form>
                            @elseif($pinjam->status === 'disetujui')
                                <form action="{{ route('peminjaman.kembali', $pinjam->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-primary">Kembalikan Buku</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">
                            <div class="alert alert-danger">
                                Data Peminjaman belum Tersedia.
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
<script>
    $(document).ready(function(){
        $("#searchInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#peminjamanTable tbody tr").filter(function() {
                $(this).toggle($(this).find("td:nth-child(2)").text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
@endpush
