@extends('layouts.user')

@section('title', 'Home')

@section('content')

@if (count($bukus) > 0)
    <div class="container py-4">
        <h1 class="text-xl font-semibold mb-4">All Books</h1>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 ">
            @foreach($bukus as $buku)
                <div class="col">
                    <div class="card h-50 w-50">
                        <a href="{{ route('books.show', $buku->id) }}">
                            <img src="{{ asset('/storage/bukus/'.$buku->image) }}" class="card-img-top rounded">
                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $buku->judul }}</h5>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@else
    <p>No books found.</p>
@endif


@endsection
