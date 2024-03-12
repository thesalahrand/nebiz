<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceStoreRequest;
use App\Http\Requests\StoreUpdateRequest;
use App\Models\Service;
use App\Models\Store;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(Store $store)
    {
        abort_if($store->user_id !== Auth::id(), 403);

        $services = Service::where('store_id', $store->id)
            ->latest()
            ->paginate()
            ->withQueryString()
            ->through(function ($service) {
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

        return view('stores.services.index', compact('store', 'services'));
    }

    public function create(Request $request, Store $store): View
    {
        abort_if($store->user_id !== Auth::id(), 403);

        return view('stores.services.create', compact('store'));
    }

    public function store(Store $store, ServiceStoreRequest $request): RedirectResponse
    {
        abort_if($store->user_id !== Auth::id(), 403);

        $validated = $request->validated();

        $service = Service::create([
            'store_id' => $store->id,
            ...$validated
        ]);

        if (isset($validated['image'])) {
            $service->addMediaFromRequest('image')->toMediaCollection('service-photos');
        }

        session()->flash('flash', [
            'toast-message' => [
                'type' => 'success',
                'message' => trans('Congratulations! The product has been successfully added to your store: ' . $store->name . '.')
            ]
        ]);

        return to_route('stores.services.index', $store->id);
    }

    public function edit(Request $request, Store $store, Service $service): View
    {
        abort_if(($store->user_id !== Auth::id()) || ($store->id !== $service->store_id), 403);

        return view('stores.services.edit', compact('store', 'service'));
    }

    public function update(StoreUpdateRequest $request, Store $store, Service $service)
    {
        abort_if($store->user_id !== Auth::id(), 403);

        $validated = $request->validated();

        $service->update($validated);

        if (isset($validated['image'])) {
            $service->clearMediaCollection('service-photos');
            $service->addMediaFromRequest('image')->toMediaCollection('service-photos');
        }


        $request->session()->flash('flash', [
            'toast-message' => [
                'type' => 'success',
                'message' => trans('Congratulations! The service has been updated successfully.')
            ]
        ]);

        return to_route('stores.services.index', $store->id);
    }

    public function destroy(Request $request, Store $store, Service $service): RedirectResponse
    {
        $service->clearMediaCollection('service-photos');
        $service->delete();

        $request->session()->flash('flash', [
            'toast-message' => [
                'type' => 'success',
                'message' => trans('Your service has been deleted successfully.')
            ]
        ]);

        return back();
    }
}
