@extends('layouts.admin')

@section('title', 'Tambah Barang')

@section('content')
    <h3 class="fw-bold mb-4">Tambah Barang</h3>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.inventaris.store') }}">
                @csrf
                @include('admin.inventaris._form')
            </form>
        </div>
    </div>
@endsection