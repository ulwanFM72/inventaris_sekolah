<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan kolom `foto` yang menyimpan path file foto barang
     * (relatif terhadap disk 'public', misal: inventaris/abc123.jpg).
     * Nullable karena tidak semua barang wajib punya foto.
     */
    public function up(): void
    {
        Schema::table('inventaris', function (Blueprint $table) {
            $table->string('foto')->nullable()->after('jumlah');
        });
    }

    public function down(): void
    {
        Schema::table('inventaris', function (Blueprint $table) {
            $table->dropColumn('foto');
        });
    }
};
