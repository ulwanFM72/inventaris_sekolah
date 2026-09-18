@extends('layouts.public')

@section('title', 'Beranda - Inventaris Sekolah')

<link rel="icon" type="image/png" href="{{ asset('images/logoremovebg.png') }}">

@section('content')
    <div class="p-5 mb-4 bg-primary text-white rounded-3 shadow-sm">
        <h1 class="display-6 fw-bold">Sistem Informasi Inventaris Sekolah</h1>
        <p class="col-md-8 fs-5">
            Platform transparan untuk melihat data barang dan aset milik sekolah,
            dapat diakses oleh seluruh warga sekolah dan masyarakat umum.
        </p>
        <a href="{{ route('inventaris.index') }}" class="btn btn-light btn-lg mt-2">Lihat Daftar Inventaris</a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-muted">Total Barang</h6>
                    <p class="display-6 fw-bold text-primary mb-0">{{ $totalBarang }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h6 class="text-muted">Jenis Barang</h6>
                    <p class="display-6 fw-bold text-success mb-0">{{ $totalJenis }}</p>
                </div>
            </div>
        </div>
    </div>

    <h5 class="mb-3">Barang Terbaru Tercatat</h5>
    <div class="row g-3">
        @foreach ($barangTerbaru as $barang)
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="card-title fw-semibold">{{ $barang->nama_barang }}</h6>
                        <p class="card-text text-muted small mb-2">{{ $barang->jenis_barang }}</p>
                        <span class="badge bg-{{ $barang->kualitasBadgeColor() }}">{{ $barang->kualitas }}</span>
                        <a href="{{ route('inventaris.show', $barang) }}" class="btn btn-sm btn-outline-primary float-end">Detail</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
