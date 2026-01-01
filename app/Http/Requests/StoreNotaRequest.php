<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNotaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'no_nota' => 'required|string|unique:notajual,no_nota',
            'tanggal' => 'required|date',
            'pelanggan_kode_pelanggan' => 'required|string|exists:pelanggan,kode_pelanggan',
            'pegawai_kode_pegawai' => 'required|string|exists:pegawai,kode_pegawai',
        ];
    }
}
