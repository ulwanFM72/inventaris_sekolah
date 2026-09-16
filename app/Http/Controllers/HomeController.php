<?php

namespace App\Http\Controllers;

use App\Models\Inventaris;

class HomeController extends Controller
{
    public function index()
    {
        $totalBarang = Inventaris::count();
        $totalJenis = Inventaris::distinct('jenis_barang')->count('jenis_barang');
        $barangTerbaru = Inventaris::latest()->take(6)->get();

        return view('public.home', compact('totalBarang', 'totalJenis', 'barangTerbaru'));
    }
}
