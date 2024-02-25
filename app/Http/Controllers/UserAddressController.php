<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAddressStoreRequest;
use App\Http\Requests\UserAddressUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\UserAddress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

        DB::transaction(function () use ($validated) {
            if ($validated['is_current'] === 1) {
                Auth::user()->addresses()->update(['is_current' => 0]);
            }

            UserAddress::create($validated);
        });

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

    public function update(UserAddressUpdateRequest $request, UserAddress $address)
    {
        abort_if($address->user_id !== Auth::id(), 403);

        $validated = $request->validated();

        DB::transaction(function () use ($validated, $address) {
            if ($validated['is_current'] === 1) {
                Auth::user()->addresses()->whereNot('id', $address->id)->update(['is_current' => 0]);
            }

            $address->update($validated);
        });

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

    public function changeCurrent(Request $request, UserAddress $address): RedirectResponse
    {
        abort_if($address->user_id !== Auth::id(), 403);

        DB::transaction(function () use ($address) {
            Auth::user()->addresses()->whereNot('id', $address->id)->update(['is_current' => 0]);
            $address->update(['is_current' => 1]);
        });

        $request->session()->flash('flash', [
            'toast-message' => [
                'type' => 'success',
                'message' => trans('Your current address has been changed successfully.')
            ]
        ]);

        return back();
    }
}
