<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePelangganRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'kode_pelanggan' => strtoupper($this->kode_pelanggan),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'kode_pelanggan' => 'required|unique:pelanggan,kode_pelanggan',
            'nama' => 'required',
            'alamat' => 'required',
            'telepon' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'kode_pelanggan.required' => 'Kode pelanggan wajib diisi.',
            'kode_pelanggan.unique' => 'Kode pelanggan sudah digunakan.',
            'nama.required' => 'Nama pelanggan wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'telepon.required' => 'Telepon wajib diisi.',
        ];
    }
}
