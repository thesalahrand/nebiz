<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\Sku;
use App\Models\Store;
use App\Services\ProductService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Store $store)
    {
        $products = Product::with(['brand', 'skus'])
            ->where('store_id', $store->id)
            ->latest()
            ->paginate()
            ->withQueryString()
            ->through(function ($product) {
                $minPrice = $product->skus->min(fn($sku) => $sku['price']);
                $maxPrice = $product->skus->max(fn($sku) => $sku['price']);
                $price_range = trans('N/R');

                if ($minPrice === $maxPrice)
                    $price_range = $minPrice . ' ' . trans('TK');
                else if ($minPrice !== $maxPrice)
                    $price_range = $minPrice . ' - ' . $maxPrice . ' ' . trans('TK');

                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'brand' => $product?->brand?->name ?? trans('N/R'),
                    'variants_count' => $product->skus->count(),
                    'price_range' => $price_range,
                    'updated_at' => $product->updated_at->format('Y-m-d H:i A')
                ];
            });

        return view('stores.products.index', compact('store', 'products'));
    }

    public function create(Request $request, Store $store): View
    {
        abort_if($store->user_id !== Auth::id(), 403);

        $brands = Brand::select('id as value', 'name')->latest()->get()->toArray();
        $product_attributes = ProductAttribute::select('id as value', 'name')->latest()->get()->toArray();

        return view('stores.products.create', compact('store', 'brands', 'product_attributes'));
    }
}
