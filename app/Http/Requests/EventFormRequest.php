<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role === 'admin';
    }

    public function rules(): array
    {
        return [
            'judul'         => ['required', 'string', 'max:255'],
            'deskripsi'     => ['required', 'string'],
            'lokasi'        => ['required', 'string', 'max:255'],
            'kategori_id'   => ['required', 'exists:kategoris,id'],
            'tanggal_waktu' => ['required', 'date', 'after:now'],
            'gambar'        => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'durasi_jam'    => ['required', 'integer', 'min:1'],
            
            'tikets'         => ['required', 'array', 'min:1'],
            'tikets.*.tipe'  => ['required', 'in:reguler,premium'],
            'tikets.*.harga' => ['required', 'numeric', 'min:0'],
            'tikets.*.stok'  => ['required', 'integer', 'min:0'],
            'tikets.*.id'    => ['nullable', 'exists:tikets,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'judul.required'         => 'Judul event wajib diisi.',
            'judul.max'              => 'Judul event maksimal 255 karakter.',
            'deskripsi.required'     => 'Deskripsi event wajib diisi.',
            'lokasi.required'        => 'Lokasi event wajib diisi.',
            'lokasi.max'             => 'Lokasi event maksimal 255 karakter.',
            'kategori_id.required'   => 'Kategori event wajib dipilih.',
            'kategori_id.exists'     => 'Kategori yang dipilih tidak valid atau tidak terdaftar.',
            'tanggal_waktu.required' => 'Tanggal dan waktu event wajib diisi.',
            'tanggal_waktu.date'     => 'Format tanggal dan waktu tidak valid.',
            'tanggal_waktu.after'    => 'Tanggal dan waktu event harus di masa depan (tidak boleh masa lalu).',
            'gambar.image'           => 'File yang diunggah harus berupa gambar.',
            'gambar.mimes'           => 'Format gambar harus berupa jpg, jpeg, atau png.',
            'gambar.max'             => 'Ukuran gambar maksimal adalah 2 MB (2048 KB).',
            
            'durasi_jam.required'    => 'Durasi event wajib diisi.',
            'durasi_jam.integer'     => 'Durasi event harus berupa angka bulat.',
            'durasi_jam.min'         => 'Durasi event minimal adalah 1 jam.',

            'tikets.required'        => 'Minimal harus menambahkan satu jenis tiket untuk event ini.',
            'tikets.array'           => 'Format data tiket tidak valid.',
            'tikets.min'             => 'Minimal harus menambahkan satu jenis tiket.',
            
            'tikets.*.tipe.required'  => 'Tipe tiket wajib dipilih.',
            'tikets.*.tipe.in'        => 'Tipe tiket harus berupa reguler atau premium.',
            
            'tikets.*.harga.required' => 'Harga tiket wajib diisi.',
            'tikets.*.harga.numeric'  => 'Harga tiket harus berupa angka.',
            'tikets.*.harga.min'      => 'Harga tiket tidak boleh kurang dari 0.',
            
            'tikets.*.stok.required'  => 'Stok tiket wajib diisi.',
            'tikets.*.stok.integer'   => 'Stok tiket harus berupa angka bulat.',
            'tikets.*.stok.min'       => 'Stok tiket tidak boleh kurang dari 0.',
            
            'tikets.*.id.exists'      => 'Data tiket yang ingin diubah tidak ditemukan di database.',
        ];
    }
}