<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Data Post - SantriKoding.com</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body style="background: lightgray">

    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <form action="{{ route('buku.update', $buku->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            @if($buku->image)
                            <div class="form-group">
                                <label class="font-weight-bold">Gambar</label>
                                <p>Gambar saat ini:</p>
                                <img src="{{ asset('/storage/bukus/'.$buku->image) }}" class="rounded" style="max-width: 150px">
                                <input type="hidden" name="old_image" value="{{ $buku->image }}">
                            </div>
                            @endif
                            

                            <div class="form-group">
                                <label class="font-weight-bold">Judul</label>
                                <input type="text" class="form-control @error('judul') is-invalid @enderror" name="judul" value="{{ old('judul') }}" placeholder="Masukkan Judul Buku">
                            
                                <!-- error message untuk judul -->
                                @error('judul')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">Penerbit</label>
                                <select class="form-control @error('penerbit_id') is-invalid @enderror" name="penerbit_id">
                                    <option value="">Pilih Penerbit</option>
                                    @foreach($penerbits as $penerbit)
                                        <option value="{{ $penerbit->id }}">{{ $penerbit->nama_penerbit }}</option>
                                    @endforeach
                                </select>
                            
                                <!-- error message untuk penerbit -->
                                @error('penerbit_id')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">Pengarang</label>
                                <select class="form-control @error('pengarang_id') is-invalid @enderror" name="pengarang_id">
                                    <option value="">Pilih Pengarang</option>
                                    @foreach($pengarangs as $pengarang)
                                        <option value="{{ $pengarang->id }}">{{ $pengarang->nama_penulis }}</option>
                                    @endforeach
                                </select>
                            
                                <!-- error message untuk pengarang -->
                                @error('pengarang_id')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">Tahun Terbit</label>
                                <input type="date" class="form-control @error('tahun_terbit') is-invalid @enderror" name="tahun_terbit" value="{{ old('tahun_terbit') }}" placeholder="Masukkan Tahun Terbit">
                            
                                <!-- error message untuk tahun_terbit -->
                                @error('tahun_terbit')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">Kategori</label>
                                <select class="form-control @error('kategori_id') is-invalid @enderror" name="kategori_id">
                                    <option value="">Pilih Kategori</option>
                                    @foreach($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            
                                <!-- error message untuk kategori -->
                                @error('kategori_id')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>


                            

                            <button type="submit" class="btn btn-md btn-primary">UPDATE</button>
                            <button type="reset" class="btn btn-md btn-warning">RESET</button>

                        </form> 
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace( 'content' );
</script>
</body>
</html>