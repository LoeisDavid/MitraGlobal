<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNotaRequest extends FormRequest
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
        // $nota = $this->route('no_nota');
        return [
            'tanggal' => 'required|date',
            'pelanggan_kode_pelanggan' => 'required|string|exists:pelanggan,kode_pelanggan',
            'pegawai_kode_pegawai' => 'required|string|exists:pegawai,kode_pegawai',
        ];
    }

    public function messages(): array
    {
        return [
            'tanggal.required' => 'Tanggal wajib diisi.',
            'tanggal.date' => 'Tanggal tidak valid.',
            'pelanggan_kode_pelanggan.required' => 'Pelanggan wajib dipilih.',
            'pelanggan_kode_pelanggan.exists' => 'Pelanggan tidak ditemukan.',
            'pegawai_kode_pegawai.required' => 'Pegawai wajib dipilih.',
            'pegawai_kode_pegawai.exists' => 'Pegawai tidak ditemukan.',
        ];
    }
}
