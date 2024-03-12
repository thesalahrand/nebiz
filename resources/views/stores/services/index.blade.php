<x-app-layout>
  @php
    $breadcrumbItems = collect([
        ['name' => __('Home'), 'link' => route('home')],
        ['name' => __('Stores'), 'link' => route('stores.index')],
        ['name' => $store->name, 'link' => route('stores.edit', $store->id)],
        ['name' => __('Services'), 'link' => route('stores.services.index', $store->id)],
    ]);
  @endphp
  <x-breadcrumb :breadcrumbItems="$breadcrumbItems" />

  <div x-data="{ idToDelete: '' }" class="mt-6">
    <div x-data="customModalHandler('#confirm-service-deletion-modal', false)">
      <x-confirm-deletion-modal htmlId="confirm-service-deletion-modal"
        deleteRoutePrefix="/stores/{{ $store->id }}/services/" title="Are you sure you want to delete this service?" />

      <div class="mb-4 flex flex-1 flex-col sm:flex-row space-y-2 sm:space-y-0 justify-between sm:items-center">
        <h1 class="text-lg font-semibold text-gray-900 dark:text-white">{{ __('My Services') }} </h1>
        <a href="{{ route('stores.services.create', $store->id) }}">
          <x-default-button class="inline-flex items-center">
            <x-icons.plus class="w-4 h-4 me-2 -mt-1" />
            {{ __('Add a Service') }}
          </x-default-button>
        </a>
      </div>

      @include('stores.services.partials.show-services-table')
    </div>
  </div>
</x-app-layout>
