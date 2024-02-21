<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStoreRequest;
use App\Models\Store;
use App\Models\StoreOpeningHour;
use App\Models\StoreType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $stores = Store::with('type')->where('user_id', Auth::id())->latest()->get();
        return view('stores.index', compact('stores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $types = StoreType::select('id as value', 'name')->latest()->get();
        return view('stores.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id();

        $store = Store::create($validated);

        if (isset($validated['cover'])) {
            $store->addMediaFromRequest('cover')->toMediaCollection('store-covers');
        }

        for ($i = 0; $i < count($validated['opening_hours']); $i++) {
            $openingHour = $validated['opening_hours'][$i];

            StoreOpeningHour::create([
                'store_id' => $store->id,
                'day_of_week' => $i,
                'is_closed' => $openingHour['is_closed'] ?? 0,
                'opens_at' => $openingHour['opens_at'] ?? null,
                'closes_at' => $openingHour['closes_at'] ?? null,
            ]);
        }

        $request->session()->flash('flash', [
            'toast-message' => [
                'type' => 'success',
                'message' => trans('Congratulations! Your store has been created successfully.')
            ]
        ]);

        return to_route('stores.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Store $store)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Store $store)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Store $store)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Store $store): RedirectResponse
    {
        $store->clearMediaCollection('store-covers');
        $store->delete();

        $request->session()->flash('flash', [
            'toast-message' => [
                'type' => 'success',
                'message' => trans('The store has been deleted successfully.')
            ]
        ]);

        return back();
    }
}
