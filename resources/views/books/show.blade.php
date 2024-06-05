<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail Data Buku - Perpustakaan</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body style="background: lightgray">
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('gagal'))
    <div class="alert alert-danger">
        {{ session('gagal') }}
    </div>
@endif

    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <img src="{{ asset('storage/bukus/'.$bukus->image) }}" class="img-fluid rounded mb-3" style="max-width: 150px;">
                            </div>
                            <div class="col-md-8">
                                <h4>{{ $bukus->judul }}</h4>
                                <p><strong>Pengarang:</strong> {{ $bukus->pengarang->nama_penulis }}</p>
                                <p><strong>Penerbit:</strong> {{ $bukus->penerbit->nama_penerbit }}</p>
                                <p><strong>Tahun Terbit:</strong> {{ $bukus->tahun_terbit }}</p>
                                <p><strong>Stock:</strong> {{ $bukus->stock }}</p>
                                <p> <td>
                                    <form action="{{ route('peminjaman.store', $bukus->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-flat btn-sm btn-warning">Pinjam Buku</button>
                                    </form>
                                </td></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
