<?php

namespace Database\Factories;

use App\Models\Inventaris;
use Illuminate\Database\Eloquent\Factories\Factory;

class InventarisFactory extends Factory
{
    protected $model = Inventaris::class;

    public function definition(): array
    {
        $jenisBarang = [
            'Elektronik',
            'Furnitur',
            'Alat Tulis Kantor',
            'Alat Laboratorium',
            'Alat Olahraga',
            'Buku',
        ];

        $namaBarangPerJenis = [
            'Elektronik' => ['Proyektor', 'Laptop', 'Printer', 'Speaker Aktif', 'Komputer PC'],
            'Furnitur' => ['Meja Guru', 'Kursi Siswa', 'Lemari Arsip', 'Papan Tulis', 'Rak Buku'],
            'Alat Tulis Kantor' => ['Spidol Whiteboard', 'Stapler', 'Kertas HVS', 'Tinta Printer'],
            'Alat Laboratorium' => ['Mikroskop', 'Tabung Reaksi', 'Gelas Ukur', 'Bunsen Burner'],
            'Alat Olahraga' => ['Bola Basket', 'Bola Voli', 'Matras', 'Net Badminton'],
            'Buku' => ['Buku Paket Matematika', 'Buku Paket IPA', 'Kamus Bahasa Inggris'],
        ];

        $jenis = $this->faker->randomElement($jenisBarang);
        $nama = $this->faker->randomElement($namaBarangPerJenis[$jenis]);

        return [
            'nama_barang' => $nama,
            'jenis_barang' => $jenis,
            'tanggal' => $this->faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
            'kualitas' => $this->faker->randomElement(Inventaris::KUALITAS_OPTIONS),
            'jumlah' => $this->faker->numberBetween(1, 50),
        ];
    }
}
