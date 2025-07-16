<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class SimpanSkriningRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'nisn' => 'nullable|string|max:25',
            'nik' => 'required|string|size:16',
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|numeric|min:1|max:31',
            'bulan_lahir' => 'required|numeric|min:1|max:12',
            'tahun_lahir' => 'required|numeric|min:1900|max:' . date('Y'),
            'golongan_darah' => 'nullable|string|in:A,B,AB,O,-',
            'jenis_kelamin' => 'required|string|in:laki-laki,perempuan',
            'provinsi' => 'required|string',
            'kota' => 'required|string',
            'kecamatan' => 'required|string',
            'kelurahan' => 'required|string',
            'alamat' => 'required|string',

            'dom-provinsi' => 'required|string',
            'dom-kota' => 'required|string',
            'dom-kecamatan' => 'required|string',
            'dom-kelurahan' => 'required|string',
            'dom-alamat' => 'required|string',

            'kelas' => 'required|numeric|min:1|max:12',
            'nama_ortu_wali' => 'required|string|max:255',
            'no_hp' => 'required|string|max:20',

            'persetujuan' => 'required|in:Setuju,Tidak',
            // 'tanda_tangan' => 'required|string|min:10',
            'puskesmas' => 'required|integer',
        ];
    }

    public function messages(): array
    {
        return [
            // 'nisn.max' => 'NISN maksimal 20 karakter.',
            'nik.required' => 'NIK wajib diisi.',
            'nik.size' => 'NIK harus terdiri dari 16 digit.',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'nama_lengkap.max' => 'Nama lengkap maksimal 255 karakter.',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.min' => 'Tanggal lahir tidak valid.',
            'tanggal_lahir.max' => 'Tanggal lahir tidak valid.',
            'bulan_lahir.required' => 'Bulan lahir wajib diisi.',
            'bulan_lahir.min' => 'Bulan lahir tidak valid.',
            'bulan_lahir.max' => 'Bulan lahir tidak valid.',
            'tahun_lahir.required' => 'Tahun lahir wajib diisi.',
            'tahun_lahir.min' => 'Tahun lahir terlalu kecil.',
            'tahun_lahir.max' => 'Tahun lahir tidak boleh melebihi tahun saat ini.',
            'golongan_darah.in' => 'Golongan darah tidak valid.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in' => 'Jenis kelamin tidak valid.',
            'provinsi.required' => 'Provinsi (KTP) wajib diisi.',
            'kota.required' => 'Kota/Kabupaten (KTP) wajib diisi.',
            'kecamatan.required' => 'Kecamatan (KTP) wajib diisi.',
            'kelurahan.required' => 'Kelurahan (KTP) wajib diisi.',
            'alamat.required' => 'Alamat (KTP) wajib diisi.',
            'dom-provinsi.required' => 'Provinsi domisili wajib diisi.',
            'dom-kota.required' => 'Kota/Kabupaten domisili wajib diisi.',
            'dom-kecamatan.required' => 'Kecamatan domisili wajib diisi.',
            'dom-kelurahan.required' => 'Kelurahan domisili wajib diisi.',
            'dom-alamat.required' => 'Alamat domisili wajib diisi.',
            'kelas.required' => 'Kelas wajib diisi.',
            'kelas.min' => 'Kelas tidak valid.',
            'kelas.max' => 'Kelas tidak valid.',
            'nama_ortu_wali.required' => 'Nama orang tua/wali wajib diisi.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'persetujuan.required' => 'Persetujuan wajib dipilih.',
            'persetujuan.in' => 'Persetujuan harus dipilih antara Setuju atau Tidak.',
            'puskesmas.required' => 'Puskesmas wajib dipilih.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => $validator->errors()->all(),
            'error_data_diri' => true
        ], 422));
    }
}
