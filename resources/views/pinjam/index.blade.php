@extends(Auth::user()->type == 'admin' ? 'layouts.app' : 'layouts.userp')

@push('css')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endpush

@section('content')
<div class="card-body">
    <h3>Daftar Peminjaman Buku</h3>
    <div class="mb-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Cari berdasarkan judul buku">
    </div>
    <div class="table-responsive">
        <table class="table table-bordered" id="peminjamanTable">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Buku</th>
                    <th scope="col">User</th>
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
                        <td>{{ $pinjam->userss->name }}</td>
                        <td>{{ $pinjam->pengajuan }}</td>
                        <td>{{ $pinjam->tangal_peminjaman }}</td>
                        <td>{{ $pinjam->tanggal_pengembalian }}</td>
                        <td>{{ $pinjam->status }}</td>
                        <td class="text-center">
                            @if ($pinjam->status == 'pengajuan')
                                <form method="POST" action="{{ route(Auth::user()->type == 'admin' ? 'admin.pinjam.accept' : 'petugas.pinjam.accept', $pinjam->id) }}" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-success">Terima</button>
                                </form>

                                <form method="POST" action="{{ route(Auth::user()->type == 'admin' ? 'admin.pinjam.tolak' : 'petugas.pinjam.tolak', $pinjam->id) }}" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-danger">Tolak</button>
                                </form>

                                <form method="POST" action="{{ route(Auth::user()->type == 'admin' ? 'admin.pinjam.remove' : 'petugas.pinjam.remove', $pinjam->id) }}" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-warning">Batalkan</button>
                                </form>
                            @endif
                            @if($pinjam->status === 'menunggu persetujuan')
                                <form action="{{ route('peminjaman.approveReturn', $pinjam->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Setujui Pengembalian</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center">
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
    $(document).ready(function() {
        // Sort functionality by ID in descending order on load
        var rows = $("#peminjamanTable tbody tr").get();
        rows.sort(function(a, b) {
            var keyA = parseInt($(a).find("td:first").text());
            var keyB = parseInt($(b).find("td:first").text());

            return keyB - keyA;
        });
        $.each(rows, function(index, row) {
            $("#peminjamanTable tbody").append(row);
        });

        // Filter functionality
        $("#searchInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#peminjamanTable tbody tr").filter(function() {
                $(this).toggle($(this).find("td:nth-child(2)").text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
@endpush
