@extends('layouts.public')

@section('title', 'Daftar Inventaris')

@section('content')
    <h3 class="fw-bold mb-4">Daftar Inventaris Sekolah</h3>

    <form method="GET" action="{{ route('inventaris.index') }}" class="row g-2 mb-4">
        <div class="col-md-6">
            <input type="text" name="q" value="{{ $keyword }}" class="form-control"
                   placeholder="Cari nama barang...">
        </div>
        <div class="col-md-4">
            <select name="jenis" class="form-select">
                <option value="">-- Semua Jenis Barang --</option>
                @foreach ($daftarJenis as $jenis)
                    <option value="{{ $jenis }}" @selected($jenisTerpilih === $jenis)>{{ $jenis }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Cari</button>
        </div>
    </form>

    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nama Barang</th>
                        <th>Jenis Barang</th>
                        <th>Tanggal</th>
                        <th>Kualitas</th>
                        <th>Jumlah</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($inventaris as $barang)
                        <tr>
                            <td>{{ $barang->nama_barang }}</td>
                            <td>{{ $barang->jenis_barang }}</td>
                            <td>{{ $barang->tanggal->format('d-m-Y') }}</td>
                            <td><span class="badge bg-{{ $barang->kualitasBadgeColor() }}">{{ $barang->kualitas }}</span></td>
                            <td>{{ $barang->jumlah }}</td>
                            <td>
                                <a href="{{ route('inventaris.show', $barang) }}" class="btn btn-sm btn-outline-primary">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Data tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $inventaris->links() }}
    </div>
@endsection
