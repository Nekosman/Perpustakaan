<!-- resources/views/pinjam/rate.blade.php -->

@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Berikan Penilaian Anda</h2>

    <form action="{{ route('peminjaman.rate', $peminjaman->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="rating">Rating (1-5)</label>
            <select name="rating" id="rating" class="form-control" required>
                <option value="">Pilih Rating</option>
                @for ($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
        </div>

        <div class="form-group">
            <label for="review">Review</label>
            <textarea name="review" id="review" rows="4" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Kirim</button>
    </form>
</div>
@endsection
