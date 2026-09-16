<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventaris;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBarang = Inventaris::count();
        $totalJenis = Inventaris::distinct('jenis_barang')->count('jenis_barang');
        $barangKondisiBaik = Inventaris::where('kualitas', 'Baik')->count();
        $barangRusak = Inventaris::whereIn('kualitas', ['Rusak Ringan', 'Rusak Berat'])->count();

        $inventarisTerbaru = Inventaris::latest()->take(8)->get();

        return view('admin.dashboard', compact(
            'totalBarang',
            'totalJenis',
            'barangKondisiBaik',
            'barangRusak',
            'inventarisTerbaru'
        ));
    }
}
