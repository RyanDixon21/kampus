<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRegistrationFormRequest extends FormRequest
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
            // Personal Info
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'regex:/^(\+62|62|0)[0-9]{9,12}$/'],
            'date_of_birth' => ['required', 'date', 'before:' . now()->subYears(15)->format('Y-m-d')],
            'address' => ['required', 'string', 'min:10', 'max:500'],
            
            // Program Selection
            'first_choice_program_id' => ['required', 'exists:study_programs,id'],
            'second_choice_program_id' => ['nullable', 'exists:study_programs,id', 'different:first_choice_program_id'],
            
            // Optional
            'referral_code' => ['nullable', 'string', 'max:50'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama lengkap wajib diisi',
            'name.regex' => 'Nama hanya boleh berisi huruf dan spasi',
            'name.max' => 'Nama maksimal 255 karakter',
            
            'email.required' => 'Alamat email wajib diisi',
            'email.email' => 'Format email tidak valid',
            
            'phone.required' => 'Nomor HP wajib diisi',
            'phone.regex' => 'Format nomor HP tidak valid (contoh: 081234567890)',
            
            'date_of_birth.required' => 'Tanggal lahir wajib diisi',
            'date_of_birth.date' => 'Format tanggal lahir tidak valid',
            'date_of_birth.before' => 'Usia minimal 15 tahun',
            
            'address.required' => 'Alamat lengkap wajib diisi',
            'address.min' => 'Alamat minimal 10 karakter',
            'address.max' => 'Alamat maksimal 500 karakter',
            
            'first_choice_program_id.required' => 'Pilihan 1 program studi wajib dipilih',
            'first_choice_program_id.exists' => 'Program studi pilihan 1 tidak valid',
            
            'second_choice_program_id.exists' => 'Program studi pilihan 2 tidak valid',
            'second_choice_program_id.different' => 'Pilihan 2 harus berbeda dengan Pilihan 1',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'Nama Lengkap',
            'email' => 'Alamat Email',
            'phone' => 'No. HP',
            'date_of_birth' => 'Tanggal Lahir',
            'address' => 'Alamat Lengkap',
            'first_choice_program_id' => 'Pilihan 1',
            'second_choice_program_id' => 'Pilihan 2',
            'referral_code' => 'Kode Referral',
        ];
    }
}
