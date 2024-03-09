<?php

namespace App\Http\Controllers;

use App\Actions\GetProductVariantsFromSession;
use App\Http\Requests\ProductStoreRequest;
use App\Models\Brand;
use App\Models\Product;
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
    public function index()
    {
        // $stores = Store::with('type')->where('user_id', Auth::id())->latest()->get();
        // return view('stores.index', compact('stores'));
    }

    public function create(Request $request, Store $store, GetProductVariantsFromSession $getProductVariantsFromSession): View
    {
        abort_if($store->user_id !== Auth::id(), 403);

        $variants = $getProductVariantsFromSession->setActionType($getProductVariantsFromSession::ACTION_CREATE)->execute();
        $brands = Brand::select('id as value', 'name')->latest()->get();

        if (session('errors')?->any()) {
            $request->session()->flash('flash', [
                'toast-message' => [
                    'type' => 'error',
                    'message' => trans('Couldn\'t create the product! Kindly review all of the validation errors and solve them one by one.')
                ]
            ]);
        }

        return view('stores.products.create', compact('store', 'brands', 'variants'));
    }

    public function store(ProductStoreRequest $request, Store $store, ProductService $productService): RedirectResponse
    {
        abort_if($store->user_id !== Auth::id(), 403);

        $validated = $request->validated();

        $productService->store($validated, $store);

        // DB::transaction(function () use ($validated, $store) {
        //     $product = Product::create([
        //         'store_id' => $store->id,
        //         'brand_id' => $validated['default_variant']['brand_id'],
        //         'name' => $validated['default_variant']['name'],
        //         'unit_name' => $validated['default_variant']['unit_name'],
        //         'additional_info' => $validated['default_variant']['additional_info'],
        //     ]);

        //     $sku = Sku::create([
        //         'product_id' => $product->id,
        //         'sku' => strtoupper(dechex((Sku::latest()?->first()?->id ?? 0) + Sku::SKU_STARTS_FROM_IN_DEC)),
        //         ...(collect($validated['default_variant'])->except('store_id', 'brand_id', 'name', 'unit_name', 'additional_info')->toArray())
        //     ]);

        //     if (isset ($validated['default_variant']['image'])) {
        //         $sku->addMedia($validated['default_variant']['image'])->toMediaCollection('sku-photos');
        //     }

        //     if (isset ($validated['other_variants'])) {
        //         foreach ($validated['other_variants'] as $otherVariant) {
        //             $sku = Sku::create([
        //                 'product_id' => $product->id,
        //                 'sku' => strtoupper(dechex((Sku::latest()?->first()?->id ?? 0) + Sku::SKU_STARTS_FROM_IN_DEC)),
        //                 ...$otherVariant
        //             ]);

        //             if (isset ($otherVariant['image'])) {
        //                 $sku->addMedia($otherVariant['image'])->toMediaCollection('sku-photos');
        //             }
        //         }
        //     }
        // });

        $request->session()->flash('flash', [
            'toast-message' => [
                'type' => 'success',
                'message' => trans('Congratulations! The product has been successfully added to your store: ' . $store->name . '.')
            ]
        ]);

        return back();
    }
}
