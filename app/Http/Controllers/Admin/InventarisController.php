<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInventarisRequest;
use App\Http\Requests\UpdateInventarisRequest;
use App\Models\Inventaris;
use Illuminate\Http\Request;

class InventarisController extends Controller
{
    /**
     * Menampilkan seluruh data inventaris dalam bentuk tabel (dengan search & filter).
     */
    public function index(Request $request)
    {
        $keyword = $request->query('q');
        $jenis = $request->query('jenis');

        $inventaris = Inventaris::query()
            ->search($keyword)
            ->jenis($jenis)
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $daftarJenis = Inventaris::query()
            ->select('jenis_barang')
            ->distinct()
            ->orderBy('jenis_barang')
            ->pluck('jenis_barang');

        return view('admin.inventaris.index', [
            'inventaris' => $inventaris,
            'daftarJenis' => $daftarJenis,
            'keyword' => $keyword,
            'jenisTerpilih' => $jenis,
        ]);
    }

    /**
     * Menampilkan form tambah barang baru.
     */
    public function create()
    {
        return view('admin.inventaris.create');
    }

    /**
     * Menyimpan data barang baru ke database.
     */
    public function store(StoreInventarisRequest $request)
    {
        Inventaris::create($request->validated());

        return redirect()
            ->route('admin.inventaris.index')
            ->with('success', 'Barang berhasil ditambahkan.');
    }

    /**
     * Menampilkan detail satu barang di sisi admin.
     */
    public function show(Inventaris $inventaris)
    {
        return view('admin.inventaris.show', compact('inventaris'));
    }

    /**
     * Menampilkan form edit barang.
     */
    public function edit(Inventaris $inventaris)
    {
        return view('admin.inventaris.edit', compact('inventaris'));
    }

    /**
     * Memperbarui data barang.
     */
    public function update(UpdateInventarisRequest $request, Inventaris $inventaris)
    {
        $inventaris->update($request->validated());

        return redirect()
            ->route('admin.inventaris.index')
            ->with('success', 'Barang berhasil diperbarui.');
    }

    /**
     * Menghapus data barang.
     * Konfirmasi penghapusan dilakukan di sisi frontend (modal Bootstrap)
     * sebelum form delete ini dikirim.
     */
    public function destroy(Inventaris $inventaris)
    {
        $inventaris->delete();

        return redirect()
            ->route('admin.inventaris.index')
            ->with('success', 'Barang berhasil dihapus.');
    }
}
