<div class="relative overflow-x-auto">
  <table class="w-full mb-4 text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
      <tr>
        <x-table-th>{{ __('ID') }}</x-table-th>
        <x-table-th>{{ __('Name') }}</x-table-th>
        <x-table-th>{{ __('Brand') }}</x-table-th>
        <x-table-th>{{ __('Variants') }}</x-table-th>
        <x-table-th>{{ __('Price Range') }}</x-table-th>
        <x-table-th>{{ __('Last Updated') }}</x-table-th>
        <x-table-th>{{ __('Action') }}</x-table-th>
      </tr>
    </thead>
    <tbody>
      @forelse ($products as $product)
        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
          <td class="px-6 py-4">
            {{ $product['id'] }}
          </td>
          <td class="px-6 py-4">
            {{ $product['name'] }}
          </td>
          <td class="px-6 py-4">
            {{ $product['brand'] }}
          </td>
          <td class="px-6 py-4">
            {{ $product['variants_count'] }}
          </td>
          <td class="px-6 py-4">
            {{ $product['price_range'] }}
          </td>
          <td class="px-6 py-4">
            {{ $product['updated_at'] }}
          </td>
          <td class="px-6 py-4">
            <div class="flex items-center space-x-1">
              {{-- <x-td-action-button href="{{ route('stores.edit', $store->id) }}">
                <x-icons.pencil class="w-5 h-5" />
              </x-td-action-button>
              <x-td-action-button class="cursor-pointer" @click="show, idToDelete = {{ $store->id }}">
                <x-icons.trash class="w-5 h-5" />
              </x-td-action-button> --}}
            </div>
          </td>
        </tr>
      @empty
        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
          <td class="px-6 py-4 text-center" colspan="6">
            {{ __('No products to show') }}
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>

  {{ $products->links() }}
</div>
