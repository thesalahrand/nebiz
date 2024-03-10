<?php

namespace App\Livewire;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use App\Enums\Unit;
use App\Models\Store;
use App\Models\Brand;
use App\Services\ProductService;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class CreateProductForm extends Component
{
    use WithFileUploads;

    public Store $store;
    public array $brands;
    public array $product_attributes;
    public array $default_variant;
    public array $other_variants = [];

    public function rules()
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

    public function mount(Store $store, array $brands, array $product_attributes)
    {
        $this->store = $store;
        $this->brands = $brands;
        $this->product_attributes = $product_attributes;
        $this->default_variant = [
            'name' => '',
            'brand_id' => '',
            'unit_name' => '',
            'price' => '',
            'quantity' => '',
            'image' => '',
            'additional_info' => '',
            'attributes' => []
        ];
    }

    public function addOtherVariant(): void
    {
        $this->other_variants[] = ['price' => '', 'quantity' => '', 'image' => '', 'attributes' => []];
    }

    public function deleteOtherVariant(int $idx): void
    {
        array_splice($this->other_variants, $idx, 1);
    }

    public function addAttributeToDefaultVariant(): void
    {
        $this->default_variant['attributes'][] = [
            'selected_id' => '',
            'values' => [],
            'selected_value_id' => ''
        ];
    }

    public function deleteAttributeFromDefaultVariant(int $attribute_idx): void
    {
        array_splice($this->default_variant['attributes'], $attribute_idx, 1);
    }

    public function addAttributeToOtherVariant(int $variant_idx): void
    {
        $this->other_variants[$variant_idx]['attributes'][] = [
            'selected_id' => '',
            'values' => [],
            'selected_value_id' => ''
        ];
    }

    public function deleteAttributeFromOtherVariant(int $variant_idx, int $attribute_idx): void
    {
        array_splice($this->other_variants[$variant_idx]['attributes'], $attribute_idx, 1);
    }

    public function onChange($variant_idx)
    {
        dd($variant_idx);
    }

    public function save(ProductService $productService)
    {
        abort_if($this->store->user_id !== Auth::id(), 403);

        $validated = $this->validate();

        $productService->store($validated, $this->store);

        session()->flash('flash', [
            'toast-message' => [
                'type' => 'success',
                'message' => trans('Congratulations! The product has been successfully added to your store: ' . $this->store->name . '.')
            ]
        ]);

        $this->redirectRoute('stores.products.create', $this->store->id);
    }

    public function render()
    {
        return view('livewire.stores.products.create-product-form');
    }
}
