<x-app-layout>
  @php
    $breadcrumbItems = collect([['name' => __('Home'), 'link' => route('home')], ['name' => __('Addresses'), 'link' => route('addresses.index')]]);
  @endphp
  <x-breadcrumb :breadcrumbItems="$breadcrumbItems" />

  <div x-data="{ idToDelete: '' }" class="mt-6">
    <div x-data="customModalHandler('#confirm-address-deletion-modal', false)">
      <x-confirm-deletion-modal htmlId="confirm-address-deletion-modal" deleteRouteName="addresses.destroy"
        title="Are you sure you want to delete your address? This action cannot be undone." />

      <div class="mb-4 flex flex-1 flex-col sm:flex-row space-y-2 sm:space-y-0 justify-between sm:items-center">
        <h1 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('My Addresses') }} </h1>
        <a href="{{ route('addresses.create') }}">
          <x-default-button class="inline-flex items-center">
            <x-icons.plus class="w-4 h-4 me-2 -mt-1" />
            {{ __('Add an address') }}
          </x-default-button>
        </a>
      </div>

      @include('addresses.partials.show-addresses-table')
    </div>
  </div>
</x-app-layout>
