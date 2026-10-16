<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class SocialProfileRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $isProfilePhoneMendatory       = setting('_lernen.phone_number_on_signup') == 'yes' ? true : false;

        return [
            'first_name'    => nameValidationRules(true),
            'last_name'     => nameValidationRules(true),
            'email'         => 'required|string|lowercase|email|max:255',
            'phone_number'  => $isProfilePhoneMendatory ? 'required|regex:/^(\+?\(?\d{1,4}\)?)?[\d\s\-]{7,15}$/' : 'nullable|regex:/^(\+?\(?\d{1,4}\)?)?[\d\s\-]{7,15}$/',
            'user_role'     => 'required|in:tutor,student',
            'terms'         => 'required|string',
            'codigo'        => 'nullable|string|max:255'
        ];
    }

    /**
     * Get the custom messages for validation errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return nameValidationMessages();
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'first_name'        => sanitizeTextField($this->first_name),
            'last_name'         => sanitizeTextField($this->last_name),
        ]);
    }
}
