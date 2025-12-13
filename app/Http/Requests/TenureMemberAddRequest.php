<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TenureMemberAddRequest extends FormRequest
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
            'tenure_id' => 'exists:tenures,id',
            'member_id' => 'exists:members,id',
            'designation' => 'required',
            'rank' => 'required|in:1,2,3,4,5'
        ];
    }

    // Custom attribute names for localization
    public function attributes(): array
    {
        return [
            'tenure_id' => __('attributes.tenure_id'),
            'member_id' => __('attributes.member_id'),
            'designation' => __('attributes.designation'),
            'rank' => __('attributes.rank')
        ];
    }
}
