<div>
    <div class="row g-2 mb-4">
        <div class="col-md-6">
            <div class="input-group">
                <span class="input-group-text bg-white">🔍</span>
                <input
                    type="text"
                    wire:model.live.debounce.400ms="search"
                    class="form-control"
                    placeholder="Ketik nama barang..."
                >
            </div>
        </div>
        <div class="col-md-4">
            <select wire:model.live="jenis" class="form-select">
                <option value="">Semua Jenis Barang</option>
                @foreach ($daftarJenis as $j)
                    <option value="{{ $j }}">{{ $j }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button
                type="button"
                wire:click="$set('search', ''); $set('jenis', '')"
                class="btn btn-outline-secondary w-100">
                Reset
            </button>
        </div>
    </div>

    <div class="card shadow-sm border-0 position-relative">

        {{-- Indikator loading kecil saat request Livewire berjalan --}}
        <div wire:loading class="position-absolute top-0 end-0 m-2">
            <span class="badge bg-primary">Memuat...</span>
        </div>

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
                        <tr wire:key="barang-{{ $barang->id }}">
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
                            <td colspan="6" class="text-center text-muted py-4">
                                Tidak ada barang yang cocok dengan pencarian "{{ $search }}".
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination bergaya Bootstrap, memakai method bawaan WithPagination
         (gotoPage, previousPage, nextPage) karena view pagination default
         Livewire berbasis Tailwind, yang tidak dipakai di project ini. --}}
    @if ($inventaris->hasPages())
        <nav class="mt-3">
            <ul class="pagination justify-content-center mb-0">
                <li class="page-item {{ $inventaris->onFirstPage() ? 'disabled' : '' }}">
                    <button type="button" class="page-link" wire:click="previousPage" @disabled($inventaris->onFirstPage())>
                        &laquo;
                    </button>
                </li>

                @for ($page = 1; $page <= $inventaris->lastPage(); $page++)
                    <li class="page-item {{ $inventaris->currentPage() === $page ? 'active' : '' }}">
                        <button type="button" class="page-link" wire:click="gotoPage({{ $page }})">
                            {{ $page }}
                        </button>
                    </li>
                @endfor

                <li class="page-item {{ !$inventaris->hasMorePages() ? 'disabled' : '' }}">
                    <button type="button" class="page-link" wire:click="nextPage" @disabled(!$inventaris->hasMorePages())>
                        &raquo;
                    </button>
                </li>
            </ul>
        </nav>
    @endif
</div>
