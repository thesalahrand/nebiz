<div class="relative overflow-x-auto">
  <table class="w-full mb-4 text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
      <tr>
        <x-table-th>{{ __('ID') }}</x-table-th>
        <x-table-th>{{ __('Name') }}</x-table-th>
        <x-table-th>{{ __('Price') }}</x-table-th>
        <x-table-th>{{ __('Last Updated') }}</x-table-th>
        <x-table-th>{{ __('Action') }}</x-table-th>
      </tr>
    </thead>
    <tbody>
      @forelse ($services as $service)
        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
          <td class="px-6 py-4">
            {{ $service['id'] }}
          </td>
          <td class="px-6 py-4">
            {{ $service['name'] }}
          </td>
          <td class="px-6 py-4">
            {{ $service['price'] }}
          </td>
          <td class="px-6 py-4">
            {{ $service['updated_at'] }}
          </td>
          <td class="px-6 py-4">
            <div class="flex items-center space-x-1">
              <x-td-action-button
                href="{{ route('stores.services.edit', ['store' => $store->id, 'service' => $service['id']]) }}">
                <x-icons.pencil class="w-5 h-5" />
              </x-td-action-button>
              <x-td-action-button class="cursor-pointer" @click="show, idToDelete = {{ $service['id'] }}">
                <x-icons.trash class="w-5 h-5" />
              </x-td-action-button>
            </div>
          </td>
        </tr>
      @empty
        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
          <td class="px-6 py-4 text-center" colspan="6">
            {{ __('No services to show') }}
          </td>
        </tr>
      @endforelse
    </tbody>
  </table>

  {{ $services->links() }}
</div>
