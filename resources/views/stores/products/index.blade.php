<x-app-layout>
  @php
    $breadcrumbItems = collect([
        ['name' => __('Home'), 'link' => route('home')],
        ['name' => __('Stores'), 'link' => route('stores.index')],
        ['name' => $store->name, 'link' => route('stores.edit', $store->id)],
        ['name' => __('Products'), 'link' => route('stores.products.index', $store->id)],
    ]);
  @endphp
  <x-breadcrumb :breadcrumbItems="$breadcrumbItems" />

  <div x-data="{ idToDelete: '' }" class="mt-6">
    <div x-data="customModalHandler('#confirm-store-deletion-modal', false)">
      {{-- <x-confirm-deletion-modal htmlId="confirm-store-deletion-modal" deleteRouteName="stores.destroy"
          title="Are you sure you want to delete your store? Doing so will delete all of your products, services and ratings too." />
   --}}
      <div class="mb-4 flex flex-1 flex-col sm:flex-row space-y-2 sm:space-y-0 justify-between sm:items-center">
        <h1 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('My Products') }} </h1>
        <a href="{{ route('stores.products.create', $store->id) }}">
          <x-default-button class="inline-flex items-center">
            <x-icons.plus class="w-4 h-4 me-2 -mt-1" />
            {{ __('Add a Product') }}
          </x-default-button>
        </a>
      </div>

      @include('stores.products.partials.show-products-table')
    </div>
  </div>
</x-app-layout>
