<x-app-layout>
  <h1 class="text-xl font-semibold text-gray-900 dark:text-white mb-6"> {{ __('Explore Nerarby Stores') }} </h1>

  <div class="grid grid-cols-4 gap-4">
    @foreach ($stores as $store)
      <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
        <a href="#">
          <img class="rounded-t-lg h-48 w-full object-cover"
            src="https://images.pexels.com/photos/958545/pexels-photo-958545.jpeg?auto=compress&cs=tinysrgb&w=600"
            alt="store-cover" />
        </a>
        <div class="p-5">
          <a href="#">
            <h5 class="mb-2 text-lg font-bold tracking-tight text-gray-900 dark:text-white">{{ $store->name }}</h5>
          </a>
          <p class="mb-2 text-sm font-normal text-gray-700 dark:text-gray-400">{{ $store->full_address }}</p>
          <p class="mb-3 text-sm font-normal text-gray-700 dark:text-gray-400 ">
            <span class="inline-flex items-center">
              <span class="text-gray-900 dark:text-white font-bold inline-flex items-center me-1">
                <x-icons.map-pin class="w-6 h-6 me-1"></x-icons.map-pin>
                {{ number_format($store->distance, 2) }} km
              </span>
              away
            </span>
          </p>
          <a href="{{ route('stores.show', $store->slug) }}"
            class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            {{ __('Visit Store') }}
            <x-icons.arrow-right class="rtl:rotate-180 w-3.5 h-3.5 ms-2">
              </x-icons.arrow-rig>
          </a>
        </div>
      </div>
    @endforeach
  </div>
</x-app-layout>
