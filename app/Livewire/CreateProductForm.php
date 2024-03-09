<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class CreateProductForm extends Component
{
    use WithFileUploads;

    public array $default_variant;
    public array $other_variants;

    public function rules()
    {
        return [
            'default_variant.name' => ['required', 'string', 'max:2'],
            // 'default_variant.brand_id' => ['nullable', 'integer', 'min:1', Rule::exists(Brand::class, 'id')->withoutTrashed()],
            // 'default_variant.unit_name' => ['required', 'string', new Enum(Unit::class)],
            'default_variant.price' => ['nullable', 'numeric', 'min:0', 'max:12'],
            // 'default_variant.quantity' => ['nullable', 'numeric', 'min:0', 'max:999999.99'],
            'default_variant.image' => ['nullable', 'file', 'mimetypes:image/png', 'max:1024'],
            // 'default_variant.additional_info' => ['nullable', 'string', 'max:1000'],
            // 'other_variants.*.price' => ['nullable', 'numeric', 'min:0', 'max:999999.99'],
            // 'other_variants.*.quantity' => ['nullable', 'numeric', 'min:0', 'max:999999.99'],
            // 'other_variants.*.image' => ['nullable', 'file', 'mimetypes:image/jpeg', 'max:1024']
        ];
    }

    public function mount()
    {
        $this->default_variant = [
            'name' => '',
            'price' => '',
            'image' => ''
        ];
    }

    public function save()
    {
        session()->flash('flash', [
            'toast-message' => [
                'type' => 'error',
                'message' => trans('Couldn\'t create the product! Kindly review all of the validation errors and solve them one by one.')
            ]
        ]);
        // $validated = $this->validate();

        // dd($validated);
    }

    public function render()
    {
        return view('livewire.products.create-product-form');
    }
}
