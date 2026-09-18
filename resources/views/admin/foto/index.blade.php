@extends('layouts.admin')

@section('title', 'Foto Barang')

@section('content')
    <h3 class="fw-bold mb-1">Foto Barang</h3>
    <p class="text-muted mb-4">
        Kelola foto untuk setiap barang inventaris. Foto yang diunggah di sini
        akan muncul di halaman detail barang pada sisi publik.
    </p>

    <form method="GET" action="{{ route('admin.foto.index') }}" class="row g-2 mb-4">
        <div class="col-md-6">
            <input type="text" name="q" value="{{ $keyword }}" class="form-control" placeholder="Cari nama barang...">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-outline-primary w-100">Cari</button>
        </div>
    </form>

    <div class="row g-3">
        @forelse ($inventaris as $barang)
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    @if ($barang->fotoUrl())
                        <img src="{{ $barang->fotoUrl() }}" class="card-img-top" style="height: 160px; object-fit: cover;" alt="{{ $barang->nama_barang }}">
                    @else
                        <div class="d-flex align-items-center justify-content-center bg-light text-muted" style="height: 160px;">
                            <span class="small">📦 Belum ada foto</span>
                        </div>
                    @endif
                    <div class="card-body">
                        <h6 class="card-title fw-semibold mb-1">{{ $barang->nama_barang }}</h6>
                        <p class="card-text text-muted small mb-3">{{ $barang->jenis_barang }}</p>
                        <a href="{{ route('admin.foto.edit', $barang) }}" class="btn btn-sm btn-primary w-100">
                            {{ $barang->fotoUrl() ? 'Ubah Foto' : 'Upload Foto' }}
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-muted text-center py-4">Belum ada data barang.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $inventaris->links('pagination::bootstrap-5') }}
    </div>
@endsection
