<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNotaJualDetilRequest extends FormRequest
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
            'kode_barang' => 'required|string',
            'qty' => 'required|integer|min:1',
            'harga' => 'required|min:0',
            'diskon' => 'required|numeric|min:0|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'kode_barang.required' => 'Barang wajib dipilih.',
            'qty.required' => 'Jumlah barang wajib diisi.',
            'qty.integer' => 'Jumlah barang harus berupa angka.',
            'qty.min' => 'Jumlah barang minimal 1.',
            'harga.min' => 'Nominal tidak boleh kurang dari 0',
            'harga.required' => 'Harga tidak boleh dikosongi',
            'diskon.required' => 'Diskon wajib diisi.',
            'diskon.numeric' => 'Diskon harus berupa angka.',
            'diskon.min' => 'Diskon tidak boleh kurang dari 0%.',
            'diskon.max' => 'Diskon tidak boleh lebih dari 100%.',
        ];
    }
}
