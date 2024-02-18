<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStoreRequest;
use App\Models\Store;
use App\Models\StoreOpeningHour;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('stores.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStoreRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id();

        $store = Store::create($validated);

        if (isset($validated['cover'])) {
            $store->addMediaFromRequest('cover')->toMediaCollection('store-covers');
        }

        for ($weekdayIdx = 0; $weekdayIdx < 7; $weekdayIdx++) {
            StoreOpeningHour::create([
                'store_id' => $store->id,
                'day_of_week' => $weekdayIdx,
                'is_closed' => $validated['opening_hours'][$weekdayIdx]['is_closed'] ?? null,
                'opens_at' => $validated['opening_hours'][$weekdayIdx]['opens_at'] ?? null,
                'closes_at' => $validated['opening_hours'][$weekdayIdx]['closes_at'] ?? null,
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
    public function destroy(Store $store)
    {
        //
    }
}
