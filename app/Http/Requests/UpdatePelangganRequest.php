<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePelangganRequest extends FormRequest
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
        $kode_pelanggan = $this->route('kode_pelanggan');
        return [
            'kode_pelanggan' => 'required|unique:pelanggan,kode_pelanggan,' . $kode_pelanggan . ',kode_pelanggan',
            'nama_pelanggan' => 'required',
            'alamat' => 'required',
            'telepon' => 'required',
        ];
    }
}
