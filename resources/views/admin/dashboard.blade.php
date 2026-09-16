@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
    <h3 class="fw-bold mb-4">Dashboard</h3>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted small">Total Barang</h6>
                    <p class="h3 fw-bold text-primary mb-0">{{ $totalBarang }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted small">Total Jenis Barang</h6>
                    <p class="h3 fw-bold text-info mb-0">{{ $totalJenis }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted small">Barang Kondisi Baik</h6>
                    <p class="h3 fw-bold text-success mb-0">{{ $barangKondisiBaik }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted small">Barang Rusak</h6>
                    <p class="h3 fw-bold text-danger mb-0">{{ $barangRusak }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white fw-semibold d-flex justify-content-between align-items-center">
            Inventaris Terbaru
            <a href="{{ route('admin.inventaris.index') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nama Barang</th>
                        <th>Jenis</th>
                        <th>Tanggal</th>
                        <th>Kualitas</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($inventarisTerbaru as $barang)
                        <tr>
                            <td>{{ $barang->nama_barang }}</td>
                            <td>{{ $barang->jenis_barang }}</td>
                            <td>{{ $barang->tanggal->format('d-m-Y') }}</td>
                            <td><span class="badge bg-{{ $barang->kualitasBadgeColor() }}">{{ $barang->kualitas }}</span></td>
                            <td>{{ $barang->jumlah }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
