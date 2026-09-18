<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventaris;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FotoBarangController extends Controller
{
    /**
     * Menampilkan daftar seluruh barang beserta status fotonya
     * (sudah ada / belum ada), sebagai pintu masuk untuk mengelola foto.
     */
    public function index(Request $request)
    {
        $keyword = $request->query('q');

        $inventaris = Inventaris::query()
            ->search($keyword)
            ->orderBy('nama_barang')
            ->paginate(12)
            ->withQueryString();

        return view('admin.foto.index', [
            'inventaris' => $inventaris,
            'keyword' => $keyword,
        ]);
    }

    /**
     * Menampilkan form upload/ubah foto untuk satu barang tertentu.
     */
    public function edit(Inventaris $inventaris)
    {
        return view('admin.foto.edit', compact('inventaris'));
    }

    /**
     * Menyimpan foto baru (upload) untuk satu barang.
     * Foto lama (jika ada) dihapus dari storage agar tidak menumpuk file yatim.
     */
    public function update(Request $request, Inventaris $inventaris)
    {
        $request->validate([
            'foto' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'foto.required' => 'Silakan pilih file foto terlebih dahulu.',
            'foto.image' => 'File yang diunggah harus berupa gambar.',
            'foto.mimes' => 'Format foto harus JPG, PNG, atau WEBP.',
            'foto.max' => 'Ukuran foto maksimal 2 MB.',
        ]);

        if ($inventaris->foto) {
            Storage::disk('public')->delete($inventaris->foto);
        }

        $path = $request->file('foto')->store('inventaris', 'public');

        // Set langsung ke properti (bukan lewat mass update()) supaya
        // tidak bergantung pada $fillable model — lihat catatan di model.
        $inventaris->foto = $path;
        $inventaris->save();

        return redirect()
            ->route('admin.foto.index')
            ->with('success', "Foto untuk \"{$inventaris->nama_barang}\" berhasil disimpan.");
    }

    /**
     * Menghapus foto barang (file di storage + kolom di database).
     */
    public function destroy(Inventaris $inventaris)
    {
        if ($inventaris->foto) {
            Storage::disk('public')->delete($inventaris->foto);
            $inventaris->foto = null;
            $inventaris->save();
        }

        return redirect()
            ->route('admin.foto.index')
            ->with('success', "Foto untuk \"{$inventaris->nama_barang}\" berhasil dihapus.");
    }
}
