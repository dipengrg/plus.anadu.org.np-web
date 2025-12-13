<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberAddRequest extends FormRequest
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
            'user_id' => 'exists:users,id',
            'name' => 'required',
            'gender' => 'required',
            'dob' => 'date',
            'address' => 'required|in:मानिखर्क,मुलबारी,साउडारा,अनडारा,कोदी',
            'current_residence' => 'required|in:local,city,abroad'
        ];
    }

    // Custom attribute names for localization
    public function attributes(): array
    {
        return [
            'user_id' => __('attributes.user_id'),
            'name' => __('attributes.name'),
            'gender' => __('attributes.gender'),
            'dob' => __('attributes.dob'),
            'address' => __('attributes.address'),
            'current_residence' => __('attributes.current_residence'),
        ];
    }
}
