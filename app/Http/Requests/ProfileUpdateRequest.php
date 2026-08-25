<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'                   => ['required', 'string', 'max:120'],
            'email'                  => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:150',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            // Field profil opsional (Pengajar / Pelajar)
            'nip'                    => ['nullable', 'string', 'max:50'],
            'nisn'                   => ['nullable', 'string', 'max:50'],
            'institution_name'       => ['nullable', 'string', 'max:150'],
            'school_name'            => ['nullable', 'string', 'max:150'],
            'subject_specialization' => ['nullable', 'string', 'max:100'],
            'grade_level'            => ['nullable', 'string', 'max:50'],
            'phone_number'           => ['nullable', 'string', 'max:30'],
        ];
    }
}
