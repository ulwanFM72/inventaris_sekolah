@extends('layouts.admin')

@section('title', 'Data Inventaris')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Data Inventaris</h3>
        <a href="{{ route('admin.inventaris.create') }}" class="btn btn-primary">+ Tambah Barang</a>
    </div>

    <form method="GET" action="{{ route('admin.inventaris.index') }}" class="row g-2 mb-3">
        <div class="col-md-6">
            <input type="text" name="q" value="{{ $keyword }}" class="form-control" placeholder="Cari nama barang...">
        </div>
        <div class="col-md-4">
            <select name="jenis" class="form-select">
                <option value="">Semua Jenis Barang</option>
                @foreach ($daftarJenis as $jenis)
                    <option value="{{ $jenis }}" @selected($jenisTerpilih === $jenis)>{{ $jenis }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-outline-primary w-100">Cari</button>
        </div>
    </form>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nama Barang</th>
                        <th>Jenis Barang</th>
                        <th>Tanggal</th>
                        <th>Kualitas</th>
                        <th>Jumlah</th>
                        <th style="width: 220px;">Aksi</th>
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
                                <a href="{{ route('admin.inventaris.show', $barang) }}" class="btn btn-sm btn-outline-secondary">Detail</a>
                                <a href="{{ route('admin.inventaris.edit', $barang) }}" class="btn btn-sm btn-outline-warning">Edit</a>
                                <button type="button" class="btn btn-sm btn-outline-danger"
                                        data-bs-toggle="modal" data-bs-target="#hapusModal{{ $barang->id }}">
                                    Hapus
                                </button>

                                <!-- Modal konfirmasi hapus -->
                                <div class="modal fade" id="hapusModal{{ $barang->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title">Konfirmasi Hapus</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah Anda yakin ingin menghapus
                                                <strong>{{ $barang->nama_barang }}</strong>?
                                                Tindakan ini tidak dapat dibatalkan.
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <form action="{{ route('admin.inventaris.destroy', $barang) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Belum ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $inventaris->links('pagination::bootstrap-5') }}
    </div>
@endsection