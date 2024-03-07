<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(): View
    {
        // $stores = Store::with('type')->where('user_id', Auth::id())->latest()->get();
        // return view('stores.index', compact('stores'));
    }

    public function create(Store $store): View
    {
        abort_if($store->user_id !== Auth::id(), 403);

        $brands = Brand::select('id as value', 'name')->latest()->get();
        return view('stores.products.create', compact('store', 'brands'));
    }
}
