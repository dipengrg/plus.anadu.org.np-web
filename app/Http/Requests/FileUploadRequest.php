<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileUploadRequest extends FormRequest
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
            'photo' => 'required|file',
        ];
    }

    // Custom attribute names for localization
    public function attributes(): array
    {
        return [
            'photo' => __('attributes.photo'),
        ];
    }
}
