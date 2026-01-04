<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateNotaJualDetilRequest extends FormRequest
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
        'kode_barang' => 'required|string|exists:barang,kode_barang',
        'qty'         => 'required|integer|min:1',
        'diskon'      => 'required|numeric|min:0|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'kode_barang.required' => 'Barang wajib dipilih.',
            'kode_barang.exists' => 'Barang tidak ditemukan.',
            'qty.required' => 'Jumlah barang wajib diisi.',
            'qty.integer' => 'Jumlah barang harus berupa angka.',
            'qty.min' => 'Jumlah barang minimal 1.',
            'diskon.required' => 'Diskon wajib diisi.',
            'diskon.numeric' => 'Diskon harus berupa angka.',
            'diskon.min' => 'Diskon tidak boleh kurang dari 0%.',
            'diskon.max' => 'Diskon tidak boleh lebih dari 100%.',
        ];
    }
}
