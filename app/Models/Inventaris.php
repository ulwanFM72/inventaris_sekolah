<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Inventaris extends Model
{
    use HasFactory;

    protected $table = 'inventaris';

    /**
     * Daftar kolom yang boleh diisi lewat mass assignment.
     * Mencegah mass assignment vulnerability.
     */
    protected $fillable = [
        'nama_barang',
        'jenis_barang',
        'tanggal',
        'kualitas',
        'jumlah',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah' => 'integer',
    ];

    /**
     * Daftar pilihan kualitas yang valid.
     * Dipakai bersama untuk validasi & dropdown di form.
     */
    public const KUALITAS_OPTIONS = [
        'Baik',
        'Cukup Baik',
        'Rusak Ringan',
        'Rusak Berat',
    ];

    /**
     * Scope pencarian nama barang.
     */
    public function scopeSearch(Builder $query, ?string $keyword): Builder
    {
        if (blank($keyword)) {
            return $query;
        }

        return $query->where('nama_barang', 'like', "%{$keyword}%");
    }

    /**
     * Scope filter berdasarkan jenis barang.
     */
    public function scopeJenis(Builder $query, ?string $jenis): Builder
    {
        if (blank($jenis)) {
            return $query;
        }

        return $query->where('jenis_barang', $jenis);
    }

    /**
     * Badge warna Bootstrap untuk setiap kondisi kualitas.
     * Dipakai di view supaya logic tampilan tidak diulang di banyak Blade file.
     */
    public function kualitasBadgeColor(): string
    {
        return match ($this->kualitas) {
            'Baik' => 'success',
            'Cukup Baik' => 'info',
            'Rusak Ringan' => 'warning',
            'Rusak Berat' => 'danger',
            default => 'secondary',
        };
    }
}
