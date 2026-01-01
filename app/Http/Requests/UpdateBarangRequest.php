<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBarangRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $kodeBarang = $this->route('barang'); 
        // asumsi route model binding: /barang/{barang}

        return [
            'nama' => 'required|string|max:45',
            'harga_jual' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'merk_kode_merk' => 'required',
            'kategori_kode_kategori' => 'required|',
        ];
    }
}
