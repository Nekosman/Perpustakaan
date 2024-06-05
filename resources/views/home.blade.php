@extends('layouts.user')

@section('title', 'Home')

@section('contents')
@if (count($bukus) > 0)
    <div style="display: flex; flex-wrap: wrap; gap: 10px;">
        @foreach($bukus as $buku)
            <div style="flex: 1 1 auto; max-width: 150px;">
                <a href="{{ route('books.show', $buku->id) }}">
                    <img src="{{ asset('/storage/bukus/'.$buku->image) }}" class="rounded" style="width: 100%;">
                </a>
            </div>
        @endforeach
    </div>
@else
    <p>No books found.</p>
@endif
@endsection
