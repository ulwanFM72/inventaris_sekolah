@extends('layouts.admin')

@section('title', $inventaris->nama_barang)

@section('content')
    <a href="{{ route('admin.inventaris.index') }}" class="btn btn-sm btn-outline-secondary mb-3">&larr; Kembali</a>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h4 class="fw-bold">{{ $inventaris->nama_barang }}</h4>
            <span class="badge bg-{{ $inventaris->kualitasBadgeColor() }} mb-3">{{ $inventaris->kualitas }}</span>

            <table class="table table-borderless w-auto">
                <tr>
                    <th class="text-muted">Jenis Barang</th>
                    <td>: {{ $inventaris->jenis_barang }}</td>
                </tr>
                <tr>
                    <th class="text-muted">Tanggal Pencatatan</th>
                    <td>: {{ $inventaris->tanggal->format('d F Y') }}</td>
                </tr>
                <tr>
                    <th class="text-muted">Jumlah</th>
                    <td>: {{ $inventaris->jumlah }} unit</td>
                </tr>
                <tr>
                    <th class="text-muted">Dicatat pada</th>
                    <td>: {{ $inventaris->created_at->format('d F Y H:i') }}</td>
                </tr>
            </table>

            <a href="{{ route('admin.inventaris.edit', $inventaris) }}" class="btn btn-warning">Edit Barang Ini</a>
        </div>
    </div>
@endsection