<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AlatRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->can('alat.kelola');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $alatYangDiubah = $this->route('alat');

        return [
            'kategori_id'   => ['required', 'exists:kategori,id'],
            'kode_alat'     => [
                'required',
                'string',
                'max:30',
                Rule::unique('alat', 'kode_alat')->ignore($alatYangDiubah),
            ],
            'nama'          => ['required', 'string', 'max:150'],
            'deskripsi'     => ['nullable', 'string', 'max:1000'],
            'stok_total'    => ['required', 'integer', 'min:0'],
            'stok_tersedia' => ['required', 'integer', 'min:0', 'lte:stok_total'],
            'kondisi'       => ['required', Rule::in(['Baik', 'Rusak Ringan', 'Rusak Berat', 'baik', 'rusak_ringan', 'rusak_berat'])],
            'foto'          => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'], 
        ];
    }

    public function messages(): array
    {
        return [
            'kategori_id.required'  => 'Kategori wajib dipilih.',
            'kode_alat.unique'      => 'Kode alat tersebut sudah terdaftar.',
            'stok_total.required'   => 'Stok total wajib diisi.',
            'stok_tersedia.required' => 'Stok tersedia wajib diisi.',
            'stok_tersedia.lte'     => 'Stok tersedia tidak boleh melebihi stok total.',
            'kondisi.in'            => 'Kondisi alat yang dipilih tidak valid.',
            'foto.max'              => 'Ukuran foto maksimal 2MB.',
            'foto.mimes'            => 'Foto harus berformat JPG, JPEG, PNG, atau WEBP.',
        ];
    }
}