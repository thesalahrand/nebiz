<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStoreRequest;
use App\Http\Requests\StoreUpdateRequest;
use App\Models\Product;
use App\Models\Service;
use App\Models\Store;
use App\Models\StoreOpeningHour;
use App\Models\StoreType;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{
    public function index(): View
    {
        $stores = Store::with('type')->where('user_id', Auth::id())->latest()->get();
        return view('stores.index', compact('stores'));
    }

    public function create(): View
    {
        $types = StoreType::select('id as value', 'name')->latest()->get();
        return view('stores.create', compact('types'));
    }

    public function store(StoreStoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        DB::transaction(function () use ($validated) {
            $store = Store::create($validated);

            if (isset ($validated['cover'])) {
                $store->addMediaFromRequest('cover')->toMediaCollection('store-covers');
            }

            $validated['opening_hours'] = collect($validated['opening_hours'])->map(function ($openingHour, $dayOfWeek) use ($store) {
                return [
                    'store_id' => $store->id,
                    'day_of_week' => $dayOfWeek,
                    ...$openingHour,
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            })->toArray();

            StoreOpeningHour::insert($validated['opening_hours']);
        });

        $request->session()->flash('flash', [
            'toast-message' => [
                'type' => 'success',
                'message' => trans('Congratulations! Your store has been created successfully.')
            ]
        ]);

        return to_route('stores.index');
    }

    public function show(Store $store)
    {
        $products = Product::with([
            'brand',
            'skus'
        ])
            ->where('store_id', $store->id)
            ->latest()
            ->get()
            ->map(function ($product) {
                $minPrice = $product->skus->min(fn($sku) => $sku['price']);
                $maxPrice = $product->skus->max(fn($sku) => $sku['price']);
                $priceRange = trans('N/R');

                if ($minPrice === $maxPrice)
                    $priceRange = $minPrice . ' ' . trans('TK');
                else if ($minPrice !== $maxPrice)
                    $priceRange = $minPrice . ' - ' . $maxPrice . ' ' . trans('TK');

                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'brand' => $product?->brand?->name ?? trans('N/R'),
                    'variants_count' => $product->skus->count(),
                    'price_range' => $priceRange,
                    'updated_at' => $product->updated_at->format('Y-m-d H:i A')
                ];
            });

        $services = Service::where('store_id', $store->id)
            ->latest()
            ->get()
            ->map(function ($service) {
                $price = trans('N/R');
                if ($service->price) {
                    $price = $service->price . ' ' . trans('TK');
                }
                if ($service->duration && $service->duration_unit_name) {
                    $price .= "/{$service->duration} {$service->duration_unit_name}";
                }

                return [
                    'id' => $service->id,
                    'name' => $service->name,
                    'price' => $price,
                    'updated_at' => $service->updated_at->format('Y-m-d H:i A')
                ];
            });

        return view('stores.show', compact('store', 'products', 'services'));
    }

    public function edit(Store $store): View
    {
        abort_if($store->user_id !== Auth::id(), 403);
        $types = StoreType::select('id as value', 'name')->latest()->get();
        return view('stores.edit', compact('store', 'types'));
    }

    public function update(StoreUpdateRequest $request, Store $store): RedirectResponse
    {
        abort_if($store->user_id !== Auth::id(), 403);

        $validated = $request->validated();

        DB::transaction(function () use ($store, $validated) {
            $store->update($validated);

            if (isset ($validated['cover'])) {
                $store->clearMediaCollection('store-covers');
                $store->addMediaFromRequest('cover')->toMediaCollection('store-covers');
            }

            foreach ($store->openingHours as $idx => $openingHour) {
                if ($openingHour['is_closed'] != $validated['opening_hours'][$idx]['is_closed'] || $openingHour['opens_at'] != $validated['opening_hours'][$idx]['opens_at'] || $openingHour['closes_at'] != $validated['opening_hours'][$idx]['closes_at']) {
                    $openingHour->update($validated['opening_hours'][$idx]);
                }
            }
        });

        $request->session()->flash('flash', [
            'toast-message' => [
                'type' => 'success',
                'message' => trans('Congratulations! Your store has been updated successfully.')
            ]
        ]);

        return to_route('stores.index');
    }

    public function destroy(Request $request, Store $store): RedirectResponse
    {
        DB::transaction(function () use ($store) {
            $store->clearMediaCollection('store-covers');
            $store->delete();
        });

        $request->session()->flash('flash', [
            'toast-message' => [
                'type' => 'success',
                'message' => trans('Your store has been deleted successfully.')
            ]
        ]);

        return back();
    }
}
