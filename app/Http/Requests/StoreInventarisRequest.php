<?php

namespace App\Http\Requests;

use App\Models\Inventaris;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreInventarisRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Otorisasi sudah ditangani oleh middleware 'admin' pada route.
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_barang' => ['required', 'string', 'max:255'],
            'jenis_barang' => ['required', 'string', 'max:255'],
            'tanggal' => ['required', 'date'],
            'kualitas' => ['required', Rule::in(Inventaris::KUALITAS_OPTIONS)],
            'jumlah' => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama_barang.required' => 'Nama barang wajib diisi.',
            'jenis_barang.required' => 'Jenis barang wajib diisi.',
            'tanggal.required' => 'Tanggal wajib diisi.',
            'tanggal.date' => 'Format tanggal tidak valid.',
            'kualitas.required' => 'Kualitas barang wajib dipilih.',
            'kualitas.in' => 'Pilihan kualitas tidak valid.',
            'jumlah.required' => 'Jumlah barang wajib diisi.',
            'jumlah.integer' => 'Jumlah harus berupa angka.',
            'jumlah.min' => 'Jumlah minimal 1.',
        ];
    }
}
