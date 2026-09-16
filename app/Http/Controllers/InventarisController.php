<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;
use Illuminate\Http\Request;

class InventarisController extends Controller
{
    /**
     * Menampilkan daftar inventaris untuk pengunjung umum.
     * Mendukung search (nama barang), filter (jenis barang), dan pagination.
     */
    public function index(Request $request)
    {
        $keyword = $request->query('q');
        $jenis = $request->query('jenis');

        $inventaris = Inventaris::query()
            ->search($keyword)
            ->jenis($jenis)
            ->orderBy('nama_barang')
            ->paginate(10)
            ->withQueryString();

        // Daftar jenis barang unik untuk dropdown filter.
        $daftarJenis = Inventaris::query()
            ->select('jenis_barang')
            ->distinct()
            ->orderBy('jenis_barang')
            ->pluck('jenis_barang');

        return view('public.inventaris.index', [
            'inventaris' => $inventaris,
            'daftarJenis' => $daftarJenis,
            'keyword' => $keyword,
            'jenisTerpilih' => $jenis,
        ]);
    }

    /**
     * Menampilkan detail satu barang untuk pengunjung umum.
     */
    public function show(Inventaris $inventaris)
    {
        return view('public.inventaris.show', compact('inventaris'));
    }
}
