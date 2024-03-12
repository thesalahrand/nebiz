<?php
namespace App\Services;

use App\Models\Store;
use App\Models\Product;
use App\Models\Sku;
use Illuminate\Support\Facades\DB;

class ProductService
{
    private array $validated;
    private Store $store;
    private Product $product;

    private function storeDefaultVariant($lastSkuId)
    {
        $this->product = Product::create([
            'store_id' => $this->store->id,
            'brand_id' => $this->validated['default_variant']['brand_id'],
            'name' => $this->validated['default_variant']['name'],
            'unit_name' => $this->validated['default_variant']['unit_name'],
            'additional_info' => $this->validated['default_variant']['additional_info'],
        ]);

        $sku = Sku::create([
            'product_id' => $this->product->id,
            'sku' => strtoupper(dechex($lastSkuId + Sku::SKU_STARTS_FROM_IN_DEC)),
            ...(collect($this->validated['default_variant'])->except('brand_id', 'name', 'unit_name', 'additional_info')->toArray())
        ]);

        if (isset($this->validated['default_variant']['image']) && $this->validated['default_variant']['image'] !== '') {
            $sku->addMedia($this->validated['default_variant']['image'])->toMediaCollection('sku-photos');
        }

        if (isset($this->validated['default_variant']['attributes'])) {
            $attributeValueIds = collect($this->validated['default_variant']['attributes'])->map(fn($el) => $el['value_id'])->toArray();
            $sku->productAttributeValues()->attach($attributeValueIds);
        }
    }

    private function storeOtherVariants($lastSkuId)
    {
        if (isset($this->validated['other_variants'])) {
            foreach ($this->validated['other_variants'] as $idx => $otherVariant) {
                $sku = Sku::create([
                    'product_id' => $this->product->id,
                    'sku' => strtoupper(dechex($lastSkuId + $idx + 1 + Sku::SKU_STARTS_FROM_IN_DEC)),
                    ...$otherVariant
                ]);

                if (isset($otherVariant['image']) && $otherVariant['image'] !== '') {
                    $sku->addMedia($otherVariant['image'])->toMediaCollection('sku-photos');
                }

                if (isset($otherVariant['attributes'])) {
                    $attributeValueIds = collect($otherVariant['attributes'])->map(fn($el) => $el['value_id'])->toArray();
                    $sku->productAttributeValues()->attach($attributeValueIds);
                }
            }
        }

    }

    public function store(array $validated, Store $store)
    {
        $this->validated = $validated;
        $this->store = $store;

        $lastSkuId = max(Sku::withTrashed()->latest()?->first()?->id ?? 0, Sku::withTrashed()->max('id') ?? 0);

        DB::transaction(function () use ($lastSkuId) {
            $this->storeDefaultVariant($lastSkuId);
            $this->storeOtherVariants($lastSkuId);
        });
    }

    public function update(array $validated, Store $store, Product $product)
    {
        $this->validated = $validated;
        $this->store = $store;
        $this->product = $product;

        $lastSkuId = max(Sku::withTrashed()->latest()?->first()?->id ?? 0, Sku::withTrashed()->max('id') ?? 0);

        DB::transaction(function () use ($lastSkuId) {
            $this->storeDefaultVariant($lastSkuId);
            $this->storeOtherVariants($lastSkuId);
        });
    }
}
?>