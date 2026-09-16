@extends('layouts.admin')

@section('title', 'Data Inventaris')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">Data Inventaris</h3>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
            + Tambah Barang
        </button>
    </div>

    <form method="GET" action="{{ route('admin.inventaris.index') }}" class="row g-2 mb-3">
        <div class="col-md-6">
            <input type="text" name="q" value="{{ $keyword }}" class="form-control" placeholder="Cari nama barang...">
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
                                <button type="button" class="btn btn-sm btn-outline-secondary"
                                        data-bs-toggle="modal" data-bs-target="#detailModal{{ $barang->id }}">
                                    Detail
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-warning"
                                        data-bs-toggle="modal" data-bs-target="#editModal{{ $barang->id }}">
                                    Edit
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger"
                                        data-bs-toggle="modal" data-bs-target="#hapusModal{{ $barang->id }}">
                                    Hapus
                                </button>
                            </td>
                        </tr>

                        {{-- Modal Detail --}}
                        <div class="modal fade" id="detailModal{{ $barang->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h6 class="modal-title fw-bold">{{ $barang->nama_barang }}</h6>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <span class="badge bg-{{ $barang->kualitasBadgeColor() }} mb-3">{{ $barang->kualitas }}</span>
                                        <table class="table table-borderless table-sm mb-0">
                                            <tr>
                                                <th class="text-muted" style="width: 160px;">Jenis Barang</th>
                                                <td>: {{ $barang->jenis_barang }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-muted">Tanggal Pencatatan</th>
                                                <td>: {{ $barang->tanggal->format('d F Y') }}</td>
                                            </tr>
                                            <tr>
                                                <th class="text-muted">Jumlah</th>
                                                <td>: {{ $barang->jumlah }} unit</td>
                                            </tr>
                                            <tr>
                                                <th class="text-muted">Dicatat pada</th>
                                                <td>: {{ $barang->created_at->format('d F Y H:i') }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Modal Edit --}}
                        <div class="modal fade" id="editModal{{ $barang->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="{{ route('admin.inventaris.update', $barang) }}">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="_modal_target" value="editModal{{ $barang->id }}">
                                        <div class="modal-header">
                                            <h6 class="modal-title fw-bold">Edit Barang: {{ $barang->nama_barang }}</h6>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            @php($formId = 'edit'.$barang->id)
                                            @include('admin.inventaris._form')
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        {{-- Modal Konfirmasi Hapus --}}
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
        {{ $inventaris->links() }}
    </div>

    {{-- Modal Tambah Barang --}}
    <div class="modal fade" id="createModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.inventaris.store') }}">
                    @csrf
                    <input type="hidden" name="_modal_target" value="createModal">
                    <div class="modal-header">
                        <h6 class="modal-title fw-bold">Tambah Barang</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        @php($formId = 'create')
                        @php($barang = null)
                        @include('admin.inventaris._form')
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--
        Auto-buka modal yang relevan:
        - Jika ada error validasi, buka kembali modal yang barusan disubmit
          (diketahui dari hidden input _modal_target yang ikut ter-flash via old()).
        - Jika datang dari link "Tambah Barang" di sidebar (?tambah=1), buka modal Tambah.
    --}}
    @php
        $modalToOpen = $errors->any() ? old('_modal_target') : null;
        $modalToOpen = $modalToOpen ?: (request('tambah') ? 'createModal' : null);
    @endphp
    @if ($modalToOpen)
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var el = document.getElementById(@json($modalToOpen));
                if (el) {
                    new bootstrap.Modal(el).show();
                }
            });
        </script>
    @endif
@endsection
