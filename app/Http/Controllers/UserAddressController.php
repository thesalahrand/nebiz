<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAddressStoreRequest;
use App\Http\Requests\UserAddressUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Auth;

class UserAddressController extends Controller
{
    public function index(): View
    {
        $addresses = UserAddress::where('user_id', Auth::id())->latest()->get();
        return view('addresses.index', compact('addresses'));
    }

    public function create(): View
    {
        return view('addresses.create');
    }

    public function store(UserAddressStoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id();
        $validated['is_current'] = isset($validated['is_current']) ? 1 : 0;

        if ($validated['is_current']) {
            Auth::user()->addresses()->update(['is_current' => 0]);
        }

        UserAddress::create($validated);

        $request->session()->flash('flash', [
            'toast-message' => [
                'type' => 'success',
                'message' => trans('Congratulations! Your address has been added successfully.')
            ]
        ]);

        return to_route('addresses.index');
    }

    public function edit(UserAddress $address)
    {
        abort_if($address->user_id !== Auth::id(), 403);
        return view('addresses.edit', compact('address'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserAddressUpdateRequest $request, UserAddress $address)
    {
        abort_if($address->user_id !== Auth::id(), 403);

        $validated = $request->validated();
        $validated['user_id'] = Auth::id();
        $validated['is_current'] = isset($validated['is_current']) ? 1 : 0;

        $address->update($validated);

        $request->session()->flash('flash', [
            'toast-message' => [
                'type' => 'success',
                'message' => trans('Congratulations! Your address has been updated successfully.')
            ]
        ]);

        return to_route('addresses.index');
    }

    public function destroy(Request $request, UserAddress $address): RedirectResponse
    {
        $address->delete();

        $request->session()->flash('flash', [
            'toast-message' => [
                'type' => 'success',
                'message' => trans('Your address has been deleted successfully.')
            ]
        ]);

        return back();
    }
}
