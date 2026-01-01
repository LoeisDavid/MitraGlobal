<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBarangRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // kalau nanti pakai policy, baru sok aman
    }

    public function rules(): array
    {
        return [
            'kode_barang' => 'required|string|max:255|unique:barang,kode_barang',
            'barcode' => 'nullable',
            'nama' => 'required|string|max:45',
            'harga_jual' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'merk_kode_merk' => 'required',
            'kategori_kode_kategori' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'kode_barang.unique' => 'Kode barang sudah dipakai. Kreatif dikit.',
            'barcode.size' => 'Barcode harus 13 karakter. Bukan 12, bukan 14.',
            'merk_kode_merk.exists' => 'Merk tidak ditemukan.',
            'kategori_kode_kategori.exists' => 'Kategori tidak ditemukan.',
        ];
    }
}
