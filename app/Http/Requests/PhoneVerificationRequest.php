<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PhoneVerificationRequest extends FormRequest
{
    // Determine if the user is authorized to make this request.
    public function authorize(): bool
    {
        return true;
    }

    // Get the validation rules that apply to the request.
    public function rules(): array
    {
        return [
            'phone' => [
                'required',
                'regex:/^(9)[0-9]{9}$/',
                'exists:users,phone'
            ],
        ];
    }

    // Custom attribute names for localization
    public function attributes(): array
    {
        return [
            'phone' => __('attributes.phone')
        ];
    }
}
