<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStoreRequest;
use App\Http\Requests\StoreUpdateRequest;
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
        abort_if($store->user_id !== Auth::id(), 403);
        $types = StoreType::select('id as value', 'name')->latest()->get();
        return view('stores.edit', compact('store', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUpdateRequest $request, Store $store)
    {
        abort_if($store->user_id !== Auth::id(), 403);

        $validated = $request->validated();
        $validated['user_id'] = Auth::id();

        $store->update($validated);

        if (isset($validated['cover'])) {
            $store->clearMediaCollection('store-covers');
            $store->addMediaFromRequest('cover')->toMediaCollection('store-covers');
        }

        foreach ($store->openingHours as $idx => $openingHour) {
            if ($openingHour['is_closed'] != $validated['opening_hours'][$idx]['is_closed'] || $openingHour['opens_at'] != $validated['opening_hours'][$idx]['opens_at'] || $openingHour['closes_at'] != $validated['opening_hours'][$idx]['closes_at']) {
                $openingHour->update($validated['opening_hours'][$idx]);
            }
        }

        $request->session()->flash('flash', [
            'toast-message' => [
                'type' => 'success',
                'message' => trans('Congratulations! Your store has been updated successfully.')
            ]
        ]);

        return to_route('stores.index');
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
