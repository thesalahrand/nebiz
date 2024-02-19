<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStoreRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'area' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:255'],
            'phone' => ['required', 'digits:10', 'regex:/^1[3456789][\d]{8}$/'],
            'email' => ['nullable', 'string', 'lowercase', 'email', 'max:255'],
            'website' => ['nullable', 'string', 'url', 'max:255'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'opening_hours' => ['required', 'array:0,1,2,3,4,5,6', 'size:7'],
            'opening_hours.*.is_closed' => ['sometimes', 'in:1'],
            'opening_hours.*.opens_at' => ['exclude_if:opening_hours.*.is_closed,1', 'nullable', 'date_format:H:i'],
            'opening_hours.*.closes_at' => ['exclude_if:opening_hours.*.is_closed,1', 'nullable', 'date_format:H:i'],
            'cover' => ['nullable', 'file', 'mimetypes:image/jpeg', 'max:1024'],
            'additional_text' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
