<x-app-layout>
  @php
    $breadcrumbItems = collect([['name' => __('Home'), 'link' => route('home')], ['name' => __('Addresses'), 'link' => route('addresses.index')], ['name' => $address->label, 'link' => route('addresses.edit', $address->id)]]);
  @endphp
  <x-breadcrumb :breadcrumbItems="$breadcrumbItems" />

  <div
    class="mt-6 p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700">
    @include('addresses.partials.edit-address-form')
  </div>
</x-app-layout>
