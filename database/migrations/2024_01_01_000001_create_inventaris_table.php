<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menjalankan migration.
     * Membuat tabel `inventaris` yang menyimpan seluruh data barang
     * inventaris sekolah.
     */
    public function up(): void
    {
        Schema::create('inventaris', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->string('jenis_barang');
            $table->date('tanggal');
            $table->enum('kualitas', [
                'Baik',
                'Cukup Baik',
                'Rusak Ringan',
                'Rusak Berat',
            ])->default('Baik');
            $table->unsignedInteger('jumlah')->default(0);
            $table->timestamps();

            // Index untuk mempercepat pencarian & filter
            $table->index('jenis_barang');
            $table->index('kualitas');
            $table->index('nama_barang');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventaris');
    }
};
