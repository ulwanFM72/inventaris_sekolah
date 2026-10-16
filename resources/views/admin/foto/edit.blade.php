@extends('layouts.admin')

@section('title', 'Foto: ' . $inventaris->nama_barang)

@section('content')
    <a href="{{ route('admin.foto.index') }}" class="btn btn-sm btn-outline-secondary mb-3">&larr; Kembali</a>

    <h3 class="fw-bold mb-4">Foto Barang: {{ $inventaris->nama_barang }}</h3>

    <div class="row g-4">
        <div class="col-md-5">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    @if ($inventaris->fotoUrl())
                        <img src="{{ $inventaris->fotoUrl() }}" class="img-fluid rounded mb-3" style="max-height: 260px;" alt="{{ $inventaris->nama_barang }}">
                    @else
                        <div class="d-flex align-items-center justify-content-center bg-light text-muted rounded mb-3" style="height: 220px;">
                            📦 Belum ada foto
                        </div>
                    @endif

                    @if ($inventaris->fotoUrl())
                        <form method="POST" action="{{ route('admin.foto.destroy', $inventaris) }}"
                              onsubmit="return confirm('Hapus foto barang ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm w-100">Hapus Foto</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="fw-semibold mb-3">
                        {{ $inventaris->fotoUrl() ? 'Ganti Foto' : 'Upload Foto Baru' }}
                    </h6>

                    <form method="POST" action="{{ route('admin.foto.update', $inventaris) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <input type="file" name="foto" accept="image/png,image/jpeg,image/webp"
                                   class="form-control @error('foto') is-invalid @enderror" required>
                            <div class="form-text">Format JPG/PNG/WEBP, maksimal 2 MB.</div>
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Simpan Foto</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
