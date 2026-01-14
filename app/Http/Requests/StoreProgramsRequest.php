<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProgramsRequest extends FormRequest
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
            'first_choice_program_id' => 'required|exists:study_programs,id',
            'second_choice_program_id' => 'nullable|exists:study_programs,id|different:first_choice_program_id'
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'first_choice_program_id.required' => 'Silakan pilih program studi pilihan pertama',
            'first_choice_program_id.exists' => 'Program studi pilihan pertama tidak valid',
            'second_choice_program_id.exists' => 'Program studi pilihan kedua tidak valid',
            'second_choice_program_id.different' => 'Program studi pilihan kedua harus berbeda dengan pilihan pertama'
        ];
    }
}
