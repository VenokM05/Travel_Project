<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'content' => 'required|string|max:2000',
            'media_urls' => 'nullable|array',
            'media_urls.*' => 'url',
            'location' => 'nullable|string|max:255',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'privacy' => 'nullable|in:public,followers,private',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'content.max' => 'Post content must not exceed 2000 characters',
            'media_urls.*.url' => 'Each media URL must be a valid URL',
            'tags.*.max' => 'Each tag must not exceed 50 characters',
            'privacy.in' => 'Privacy must be public, followers, or private',
        ];
    }
}
