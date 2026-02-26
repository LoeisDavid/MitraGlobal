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
            'harga_beli' => 'required|numeric|min:0',
            'diskon' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'merk_kode_merk' => 'required',
            'kategori_kode_kategori' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'kode_barang.unique' => 'Kode barang sudah digunakan.',
            // 'barcode.size' => 'Barcode harus 13 karakter. Bukan 12, bukan 14.',
            'merk_kode_merk.exists' => 'Merk tidak ditemukan.',
            'kategori_kode_kategori.exists' => 'Kategori tidak ditemukan.',
            'nama.required' => 'Nama barang wajib diisi.',
            'harga_beli.required' => 'Harga jual wajib diisi.',
            'harga_beli.numeric' => 'Harga jual harus berupa angka.',
            'harga_beli.min' => 'Harga jual tidak boleh kurang dari 0.',
            'diskon.required' => 'Diskon wajib diisi.',
            'diskon.numeric' => 'Diskon harus berupa angka.',
            'diskon.min' => 'Diskon tidak boleh kurang dari 0.',
            'stok.required' => 'Stok wajib diisi.',
            'stok.integer' => 'Stok harus berupa angka.',
            'stok.min' => 'Stok tidak boleh kurang dari 0.',
        ];
    }
}
