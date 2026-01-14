<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
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
            'voucher_code' => ['nullable', 'string', 'max:50'],
            'payment_method' => ['required', 'exists:payment_methods,code']
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'payment_method.required' => 'Silakan pilih metode pembayaran',
            'payment_method.exists' => 'Metode pembayaran yang dipilih tidak valid',
            'voucher_code.max' => 'Kode voucher maksimal 50 karakter'
        ];
    }
}
