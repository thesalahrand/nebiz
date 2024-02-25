<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\StoreType;
use Illuminate\Support\Facades\Auth;

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
            'address' => ['required', 'string', 'max:255'],
            'store_type_id' => ['required', 'integer', 'min:1', Rule::exists(StoreType::class, 'id')->withoutTrashed()],
            'area' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:255'],
            'phone' => ['required', 'digits:10', 'regex:/^1[3456789][\d]{8}$/'],
            'email' => ['nullable', 'string', 'lowercase', 'email', 'max:255'],
            'website' => ['nullable', 'string', 'url', 'max:255'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'opening_hours' => ['required', 'array:0,1,2,3,4,5,6', 'size:7'],
            'opening_hours.*.is_closed' => ['sometimes', 'in:on'],
            'opening_hours.*.opens_at' => ['exclude_if:opening_hours.*.is_closed,on', 'nullable', 'date_format:H:i'],
            'opening_hours.*.closes_at' => ['exclude_if:opening_hours.*.is_closed,on', 'nullable', 'date_format:H:i'],
            'cover' => ['nullable', 'file', 'mimetypes:image/jpeg', 'max:1024'],
            'additional_info' => ['nullable', 'string', 'max:1000'],
        ];
    }


    public function validated($key = null, $default = null)
    {
        $openingHours = $this->input('opening_hours');

        foreach ($openingHours as &$openingHour) {
            $openingHour['is_closed'] = isset($openingHour['is_closed']) ? 1 : 0;
            $openingHour['opens_at'] = $openingHour['opens_at'] ?? null;
            $openingHour['closes_at'] = $openingHour['closes_at'] ?? null;
        }

        return array_merge(parent::validated(), ['user_id' => Auth::id(), 'opening_hours' => $openingHours]);
    }
}
