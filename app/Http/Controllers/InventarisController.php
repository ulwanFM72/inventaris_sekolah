<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;

class InventarisController extends Controller
{
    /**
     * Menampilkan halaman daftar inventaris untuk pengunjung umum.
     * Pencarian, filter jenis, dan pagination kini ditangani langsung oleh
     * komponen Livewire <livewire:inventaris-search /> di dalam view ini,
     * jadi controller hanya perlu me-render halamannya saja.
     */
    public function index()
    {
        return view('public.inventaris.index');
    }

    /**
     * Menampilkan detail satu barang untuk pengunjung umum.
     */
    public function show(Inventaris $inventaris)
    {
        return view('public.inventaris.show', compact('inventaris'));
    }
}
