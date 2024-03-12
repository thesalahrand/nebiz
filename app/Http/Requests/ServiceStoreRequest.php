<?php

namespace App\Http\Requests;

use App\Enums\DurationUnit;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class ServiceStoreRequest extends FormRequest
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
            'price' => ['nullable', 'numeric', 'min:0', 'max:999999.99'],
            'duration' => ['nullable', 'numeric', 'min:0', 'max:999999.99'],
            'duration_unit_name' => ['nullable', 'string', new Enum(DurationUnit::class)],
            'image' => ['nullable', 'file', 'mimetypes:image/jpeg', 'max:1024'],
            'additional_info' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
