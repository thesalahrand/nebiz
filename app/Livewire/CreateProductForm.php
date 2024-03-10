<?php

namespace App\Livewire;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use App\Enums\Unit;
use App\Models\Store;
use App\Models\Brand;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;
use App\Services\ProductService;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;

class CreateProductForm extends Component
{
    use WithFileUploads;

    private const DEFAULT_VARIANT_IDX = 0;

    public Store $store;
    public array $brands;
    public array $product_attributes;
    public array $default_variant;
    public array $other_variants = [];
    public string $test = '';

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
            'default_variant.attributes' => ['nullable', 'array'],
            // FIXME: check if product_attribute_value is a children of product_attribute
            'default_variant.attributes.*.id' => ['required', 'integer', 'min:1', 'distinct', Rule::exists(ProductAttribute::class, 'id')->withoutTrashed()],
            'default_variant.attributes.*.value_id' => ['required', 'integer', 'min:1', 'distinct', Rule::exists(ProductAttributeValue::class, 'id')->withoutTrashed()],
            'other_variants' => ['nullable', 'array'],
            'other_variants.*.price' => ['nullable', 'numeric', 'min:0', 'max:999999.99'],
            'other_variants.*.quantity' => ['nullable', 'numeric', 'min:0', 'max:999999.99'],
            'other_variants.*.image' => ['nullable', 'file', 'mimetypes:image/jpeg', 'max:1024'],
            'other_variants.*.attributes' => ['nullable', 'array'],
            // FIXME: check if product_attribute_value is a children of product_attribute
            'other_variants.*.attributes.*.id' => ['required', 'integer', 'min:1', 'distinct', Rule::exists(ProductAttribute::class, 'id')->withoutTrashed()],
            'other_variants.*.attributes.*.value_id' => ['required', 'integer', 'min:1', 'distinct', Rule::exists(ProductAttributeValue::class, 'id')->withoutTrashed()],
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

    public function addAttributeToVariant($variant_idx): void
    {
        $new_attribute = [
            'id' => '',
            'values' => [],
            'value_id' => ''
        ];

        if ($variant_idx === self::DEFAULT_VARIANT_IDX) {
            $this->default_variant['attributes'][] = $new_attribute;
        } else {
            $other_variant_idx = $variant_idx - 1;
            $this->other_variants[$other_variant_idx]['attributes'][] = $new_attribute;
        }
    }

    public function deleteAttributeFromVariant(int $variant_idx, int $attribute_idx): void
    {
        if ($variant_idx === self::DEFAULT_VARIANT_IDX) {
            array_splice($this->default_variant['attributes'], $attribute_idx, 1);
        } else {
            $other_variant_idx = $variant_idx - 1;
            array_splice($this->other_variants[$other_variant_idx]['attributes'], $attribute_idx, 1);
        }
    }

    public function onUpdateAttribute($property, $value)
    {
        $product_attribute_values = ProductAttributeValue::select('id as value', 'name')
            ->where('product_attribute_id', $value)
            ->latest()
            ->get()
            ->toArray();

        if (strpos($property, 'default_variant') === 0) {
            [, , $attribute_idx,] = explode('.', $property);
            $this->default_variant['attributes'][$attribute_idx]['values'] = $product_attribute_values;
            $this->default_variant['attributes'][$attribute_idx]['value_id'] = '';
        } else if (strpos($property, 'other_variants') === 0) {
            [, $variant_idx, , $attribute_idx,] = explode('.', $property);
            $this->other_variants[$variant_idx]['attributes'][$attribute_idx]['values'] = $product_attribute_values;
            $this->other_variants[$variant_idx]['attributes'][$attribute_idx]['value_id'] = '';
        }
    }

    public function updated($property, $value)
    {
        if (preg_match("/\.attributes\.\d+\.id$/", $property)) {
            $this->onUpdateAttribute($property, $value);
        }
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

        $this->redirectRoute('stores.products.index', $this->store->id);
    }

    public function render()
    {
        return view('livewire.stores.products.create-product-form');
    }
}
