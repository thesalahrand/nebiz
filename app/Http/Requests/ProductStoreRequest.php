<?php

namespace App\Http\Requests;

use App\Enums\Unit;
use App\Models\Brand;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class ProductStoreRequest extends FormRequest
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
            'default_variant.name' => ['required', 'string', 'max:255'],
            'default_variant.brand_id' => ['nullable', 'integer', 'min:1', Rule::exists(Brand::class, 'id')->withoutTrashed()],
            'default_variant.unit_name' => ['required', 'string', new Enum(Unit::class)],
            'default_variant.price' => ['nullable', 'numeric', 'min:0', 'max:999999.99'],
            'default_variant.quantity' => ['nullable', 'numeric', 'min:0', 'max:999999.99'],
            'default_variant.image' => ['nullable', 'file', 'mimetypes:image/jpeg', 'max:1024'],
            'default_variant.additional_info' => ['nullable', 'string', 'max:1000'],
            'other_variants.*.price' => ['nullable', 'numeric', 'min:0', 'max:999999.99'],
            'other_variants.*.quantity' => ['nullable', 'numeric', 'min:0', 'max:999999.99'],
            'other_variants.*.image' => ['nullable', 'file', 'mimetypes:image/jpeg', 'max:1024']
        ];
    }
}
