<?php

namespace App\Livewire;

use App\Models\Inventaris;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class InventarisSearch extends Component
{
    use WithPagination;

    /**
     * #[Url] membuat nilai pencarian & filter ikut tersimpan di query string
     * (?search=...&jenis=...), sehingga URL tetap bisa di-bookmark/dibagikan
     * meskipun pencarian dilakukan secara real-time tanpa reload halaman.
     */
    #[Url(as: 'q', history: true)]
    public string $search = '';

    #[Url(as: 'jenis', history: true)]
    public string $jenis = '';

    /**
     * Setiap kali properti $search atau $jenis berubah (saat pengguna mengetik
     * atau memilih filter), kembalikan pagination ke halaman 1. Tanpa ini,
     * pengguna bisa "nyangkut" di halaman 3 padahal hasil pencarian barunya
     * hanya punya 1 halaman.
     */
    public function updated(string $property): void
    {
        if (in_array($property, ['search', 'jenis'])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        $inventaris = Inventaris::query()
            ->search($this->search)
            ->jenis($this->jenis)
            ->orderBy('nama_barang')
            ->paginate(10);

        $daftarJenis = Inventaris::query()
            ->select('jenis_barang')
            ->distinct()
            ->orderBy('jenis_barang')
            ->pluck('jenis_barang');

        return view('livewire.inventaris-search', [
            'inventaris' => $inventaris,
            'daftarJenis' => $daftarJenis,
        ]);
    }
}
