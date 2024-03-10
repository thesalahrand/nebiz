<x-app-layout>
  @php
    $breadcrumbItems = collect([
        ['name' => __('Home'), 'link' => route('home')],
        ['name' => __('Stores'), 'link' => route('stores.index')],
        ['name' => $store->name, 'link' => route('stores.edit', $store->id)],
        ['name' => __('Products'), 'link' => route('stores.products.index', $store->id)],
        ['name' => __('Create'), 'link' => route('stores.products.create', $store->id)],
    ]);
  @endphp
  <x-breadcrumb :breadcrumbItems="$breadcrumbItems" />

  <div
    class="mt-6 p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700">
    <livewire:create-product-form :store="$store" :brands="$brands" :product_attributes="$product_attributes" />
  </div>
</x-app-layout>
