@extends('layouts.admin')

@section('title', 'Edit Barang')

@section('content')
    <h3 class="fw-bold mb-4">Edit Barang: {{ $inventaris->nama_barang }}</h3>

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.inventaris.update', $inventaris) }}">
                @csrf
                @method('PUT')
                @php($barang = $inventaris)
                @include('admin.inventaris._form')
            </form>
        </div>
    </div>
@endsection