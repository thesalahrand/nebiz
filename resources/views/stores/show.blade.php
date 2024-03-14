<x-app-layout>
  @php
    $breadcrumbItems = collect([
        ['name' => __('Home'), 'link' => route('home')],
        ['name' => $store->name, 'link' => "stores/{$store->slug}"],
    ]);
  @endphp
  <x-breadcrumb :breadcrumbItems="$breadcrumbItems" />

  <div class="mt-6" x-data="{ showProducts: true }">
    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $store->name }}</h5>
    <p class="mb-2 text-sm font-normal text-gray-700 dark:text-gray-400">{{ $store->full_address }}</p>

    <div
      class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700 mt-6">
      <ul class="flex flex-wrap -mb-px">
        <li class="me-2">
          <a class="inline-flex items-center p-4 border-b-2 rounded-t-lg cursor-pointer"
            :class="{
                'text-blue-600 border-blue-600 active dark:text-blue-500 dark:border-blue-500': showProducts,
                'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300': !showProducts
            }">
            <span x-on:click="showProducts = true">{{ __('Products') }}</span>
          </a>
        </li>
        <li>
          <a class="inline-flex items-center p-4 border-b-2 rounded-t-lg cursor-pointer"
            :class="{
                'text-blue-600 border-blue-600 active dark:text-blue-500 dark:border-blue-500': !showProducts,
                'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300': showProducts
            }">
            <span x-on:click="showProducts = false">{{ __('Services') }}</span>
          </a>
        </li>
      </ul>
    </div>

    <div class="mt-6">
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6" x-show="showProducts">
        @forelse ($products as $product)
          <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <h6 class="mb-2 font-bold tracking-tight text-gray-900 dark:text-white">{{ $product['name'] }}</h6>
            <p class="mb-1 text-gray-700 text-sm dark:text-gray-400">
              <span class="font-bold tracking-tight text-gray-900 dark:text-white">Brand:</span>
              {{ $product['brand'] }}
            </p>
            <p class="mb-1 text-gray-700 text-sm dark:text-gray-400">
              <span class="font-bold tracking-tight text-gray-900 dark:text-white">Variants:</span>
              {{ $product['variants_count'] }}</span>
            </p>
            <p class="mb-1 text-gray-700 text-sm dark:text-gray-400">
              <span class="font-bold tracking-tight text-gray-900 dark:text-white">Price:</span>
              {{ $product['price_range'] }}
            </p>
            <p class="text-gray-700 text-sm dark:text-gray-400">
              <span class="font-bold tracking-tight text-gray-900 dark:text-white">Last Updated:</span>
              {{ $product['updated_at'] }}
            </p>
          </div>
        @empty
          <p class="mb-2 text-sm font-normal text-gray-500 dark:text-gray-400">{{ __('No products to show') }}</p>
        @endforelse
      </div>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6" x-show="!showProducts">
        @forelse ($services as $service)
          <div class="p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
            <h6 class="mb-2 font-bold tracking-tight text-gray-900 dark:text-white">{{ $service['name'] }}
            </h6>
            <p class="mb-1 text-gray-700 text-sm dark:text-gray-400">
              <span class="font-bold tracking-tight text-gray-900 dark:text-white">Brand:</span>
              {{ $service['price'] }}
            </p>
            <p class="text-gray-700 text-sm dark:text-gray-400">
              <span class="font-bold tracking-tight text-gray-900 dark:text-white">Last Updated:</span>
              {{ $service['updated_at'] }}
            </p>
          </div>
        @empty
          <p class="mb-2 text-sm font-normal text-gray-500 dark:text-gray-400">{{ __('No services to show') }}</p>
        @endforelse
      </div>
    </div>
  </div>
</x-app-layout>
