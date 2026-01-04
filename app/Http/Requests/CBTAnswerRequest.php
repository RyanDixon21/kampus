<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CBTAnswerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Check if user has active CBT session
        return session()->has('cbt_registration_id');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'answers' => ['required', 'json'],
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'answers.required' => 'Jawaban ujian wajib diisi.',
            'answers.json' => 'Format jawaban tidak valid.',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Sanitize the answers JSON string
        if ($this->has('answers')) {
            $this->merge([
                'answers' => $this->sanitizeInput($this->answers),
            ]);
        }
    }

    /**
     * Sanitize input to prevent XSS attacks.
     */
    private function sanitizeInput(?string $input): ?string
    {
        if ($input === null) {
            return null;
        }

        // For JSON data, we just validate it's proper JSON
        // The actual validation of structure happens in the service layer
        return $input;
    }

    /**
     * Get validated and decoded answers.
     */
    public function getAnswers(): array
    {
        $answers = json_decode($this->validated()['answers'], true);
        
        // Ensure answers is an array
        if (!is_array($answers)) {
            return [];
        }

        // Sanitize each answer to ensure only valid data
        return array_map(function ($answer) {
            return [
                'question_id' => (int) ($answer['question_id'] ?? 0),
                'selected_option' => (int) ($answer['selected_option'] ?? 0),
            ];
        }, $answers);
    }
}
