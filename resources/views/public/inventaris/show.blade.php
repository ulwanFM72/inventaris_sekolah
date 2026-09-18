@extends('layouts.public')

@section('title', $inventaris->nama_barang)

@section('content')
    <a href="{{ route('inventaris.index') }}" class="btn btn-sm btn-outline-secondary mb-3">&larr; Kembali</a>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="row g-4">
                @if ($inventaris->fotoUrl())
                    <div class="col-md-4">
                        <img src="{{ $inventaris->fotoUrl() }}" class="img-fluid rounded" alt="{{ $inventaris->nama_barang }}">
                    </div>
                @endif

                <div class="{{ $inventaris->fotoUrl() ? 'col-md-8' : 'col-12' }}">
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
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
