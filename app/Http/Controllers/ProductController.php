<?php

namespace App\Http\Controllers;

use App\Actions\GetProductVariantsFromSession;
use App\Http\Requests\ProductStoreRequest;
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
    public function index()
    {
        // $stores = Store::with('type')->where('user_id', Auth::id())->latest()->get();
        // return view('stores.index', compact('stores'));
    }

    public function create(Request $request, Store $store, GetProductVariantsFromSession $getProductVariantsFromSession): View
    {
        abort_if($store->user_id !== Auth::id(), 403);

        $variants = $getProductVariantsFromSession->setActionType($getProductVariantsFromSession::ACTION_CREATE)->execute();
        $brands = Brand::select('id as value', 'name')->latest()->get()->toArray();
        $product_attributes = ProductAttribute::select('id as value', 'name')->latest()->get()->toArray();

        return view('stores.products.create', compact('store', 'brands', 'product_attributes'));
    }
}
