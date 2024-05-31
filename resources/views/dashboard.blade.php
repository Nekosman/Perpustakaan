@extends('layouts.app')

@section('title', 'Perpus TB')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Dashboard</h3>
                </div>
                <div class="card-body">
                    <h4>Total Buku: {{ $totalBooks }}</h4>
                    <h4>Total Users: {{ $totalUsers }}</h4>
                </div>
            </div>
        </div>
    </div>
@endsection