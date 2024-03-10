<section class="w-full max-w-3xl">
  <form method="post" wire:submit="save" enctype="multipart/form-data" x-data="{ currVariantIdx: 0 }">
    <h5 class="text-xl font-semibold text-gray-900 dark:text-white"> {{ __('Create a Product') }} </h5>
    <div
      class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700 mt-6">
      <ul class="flex flex-wrap -mb-px">
        @foreach ([$default_variant, ...$other_variants] as $idx => $variant)
          <li class="me-2" wire:key="{{ $idx }}">
            <a class="inline-flex items-center p-4 border-b-2 rounded-t-lg cursor-pointer"
              :class="{
                  'text-blue-600 border-blue-600 active dark:text-blue-500 dark:border-blue-500': {{ $idx }} ===
                      currVariantIdx,
                  'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300': {{ $idx }} !==
                      currVariantIdx
              }">
              <span x-on:click="currVariantIdx = {{ $idx }}">Variant #{{ $idx + 1 }}</span>
              @if ($idx !== 0)
                <button type="button"
                  class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-full text-sm w-5 h-5 ms-4 inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                  wire:click="deleteOtherVariant({{ $idx - 1 }});" x-on:click="currVariantIdx = 0">
                  <x-icons.close class="w-2.5 h-2.5 " />
                </button>
              @endif
            </a>
          </li>
        @endforeach

        <li class="me-2">
          <a class="inline-flex items-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 cursor-pointer"
            wire:click.prevent="addOtherVariant">
            <x-icons.plus class="w-4 h-4 me-2 -mt-1" />
            {{ __('Add') }}
          </a>
        </li>
      </ul>
    </div>

    @if ($errors->any())
      <x-alert class="mt-6" htmlId="alert-1" :text="__(
          'Couldn\'t create the product! Kindly review all of the validation errors and solve them one by one.',
      )" />
    @endif

    @foreach ([$default_variant, ...$other_variants] as $idx => $variant)
      <div wire:key="{{ $idx }}"
        x-bind:class="{{ $idx }} === currVariantIdx ? '' : 'max-h-0 overflow-hidden'">
        <template x-if="{{ $idx }} === 0">
          <div class="mt-6">
            <x-input-label for="default_variant.name" :value="__('Name')" required="true" />
            <x-text-input id="default_variant.name" name="default_variant.name" type="text" required autofocus
              autocomplete="default_variant.name" maxlength="255" wire:model="default_variant.name" />
            <x-input-error :messages="$errors->get('default_variant.name')" />
          </div>
        </template>

        <template x-if="{{ $idx }} === 0">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6">
            <div>
              <x-input-label for="default_variant.brand_id" :value="__('Brand')" />
              <x-select-input id="default_variant.brand_id" name="default_variant.brand_id" :options="collect($brands)"
                chooseOptionText="Select a Brand" autocomplete="default_variant.brand_id"
                wire:model="default_variant.brand_id" />
              <x-input-error :messages="$errors->get('default_variant.brand_id')" />
            </div>
            <div>
              <x-input-label for="default_variant.unit_name" :value="__('Unit Name')" required="true" />
              <x-select-input id="default_variant.unit_name" name="default_variant.unit_name" :options="App\Enums\Unit::toCollection()"
                chooseOptionText="Select a unit name" autocomplete="default_variant.unit_name"
                wire:model="default_variant.unit_name" required />
              <x-input-error :messages="$errors->get('default_variant.unit_name')" />
            </div>
          </div>
        </template>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6">
          <div>
            <x-input-label for="{{ $idx > 0 ? 'other_variants.' . ($idx - 1) . '.price' : 'default_variant.price' }}"
              :value="__('Price')" />
            <x-text-input id="{{ $idx > 0 ? 'other_variants.' . ($idx - 1) . '.price' : 'default_variant.price' }}"
              name="{{ $idx > 0 ? 'other_variants.' . ($idx - 1) . '.price' : 'default_variant.price' }}"
              type="number" step="0.01"
              autocomplete="{{ $idx > 0 ? 'other_variants.' . ($idx - 1) . '.price' : 'default_variant.price' }}"
              min="0" max="999999.99"
              wire:model="{{ $idx > 0 ? 'other_variants.' . ($idx - 1) . '.price' : 'default_variant.price' }}" />
            <x-input-error :messages="$errors->get($idx > 0 ? 'other_variants.' . ($idx - 1) . '.price' : 'default_variant.price')" />

          </div>
          <div>
            <x-input-label
              for="{{ $idx > 0 ? 'other_variants.' . ($idx - 1) . '.quantity' : 'default_variant.quantity' }}"
              :value="__('Stock Quantity')" />
            <x-text-input
              id="{{ $idx > 0 ? 'other_variants.' . ($idx - 1) . '.quantity' : 'default_variant.quantity' }}"
              name="{{ $idx > 0 ? 'other_variants.' . ($idx - 1) . '.quantity' : 'default_variant.quantity' }}"
              type="number" step="0.01"
              autocomplete="{{ $idx > 0 ? 'other_variants.' . ($idx - 1) . '.quantity' : 'default_variant.quantity' }}"
              min="0" max="999999.99"
              wire:model="{{ $idx > 0 ? 'other_variants.' . ($idx - 1) . '.quantity' : 'default_variant.quantity' }}" />
            <x-input-error :messages="$errors->get(
                $idx > 0 ? 'other_variants.' . ($idx - 1) . '.quantity' : 'default_variant.quantity',
            )" />
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6">
          <div x-data="imageViewer(@js(asset('images/placeholder-image.png')))">
            <x-input-label for="{{ $idx > 0 ? 'other_variants.' . ($idx - 1) . '.image' : 'default_variant.image' }}"
              :value="__('Image')" />
            <x-file-input id="{{ $idx > 0 ? 'other_variants.' . ($idx - 1) . '.image' : 'default_variant.image' }}"
              name="{{ $idx > 0 ? 'other_variants.' . ($idx - 1) . '.image' : 'default_variant.image' }}"
              type="file" accept=".jpg, .jpeg"
              wire:model="{{ $idx > 0 ? 'other_variants.' . ($idx - 1) . '.image' : 'default_variant.image' }}"
              @change="fileChosen" />
            <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">
              {{ __('The image must be in JPG format (max 1 MB).') }}</div>
            <x-input-error :messages="$errors->get($idx > 0 ? 'other_variants.' . ($idx - 1) . '.image' : 'default_variant.image')" />
            <img :src="imageUrl" class="rounded mt-2 w-16 object-cover" alt="product-image">
          </div>
          <template x-if="{{ $idx }} === 0">
            <div>
              <x-input-label for="default_variant.additional_info" :value="__('Write more about your product')" />
              <x-textarea-input rows="9" id="default_variant.additional_info"
                name="default_variant.additional_info" autocomplete="default_variant.additional_info" maxlength="1000"
                placeholder="{{ __('Additional information about your store..') }}"
                wire:model="default_variant.additional_info"></x-textarea-input>
              <x-input-error :messages="$errors->get('default_variant.additional_info')" />
            </div>
          </template>
        </div>

        <div class="relative overflow-x-auto mt-6">
          <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
              <tr>
                <th scope="col" class="px-6 py-3">
                  {{ __('Attribute') }}
                </th>
                <th scope="col" class="px-6 py-3">
                  {{ __('Attribute Value') }}
                </th>
                <th scope="col" class="px-6 py-3">
                  {{ __('Action') }}
                </th>
              </tr>
            </thead>
            <tbody>
              @forelse ($variant['attributes'] as $attribute_idx => $attribute)
                <tr wire:key="{{ $attribute_idx }}" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                  <td class="px-6 py-4">
                    <x-select-input name="default_variant.brand_id" :options="collect($product_attributes)"
                      chooseOptionText="Select an Attribute"
                      autocomplete="{{ $idx > 0 ? 'other_variants.' . ($idx - 1) . '.attribute.' . $attribute_idx . '.selected_id' : 'default_variant.attributes.selected_id' }}"
                      wire:model="{{ $idx > 0 ? 'other_variants.' . ($idx - 1) . '.attribute.' . $attribute_idx . '.selected_id' : 'default_variant.attributes.' . $attribute_idx . '.selected_id' }}"
                      x-on:change="$wire.onChange({{ $idx }})" />
                    <x-input-error :messages="$errors->get(
                        $idx > 0
                            ? 'other_variants.' . ($idx - 1) . '.attribute.' . $attribute_idx . '.selected_id'
                            : 'default_variant.attributes.' . $attribute_idx . '.selected_id',
                    )" />
                  </td>
                  <td class="px-6 py-4">
                    {{-- <x-select-input name="default_variant.brand_id" :options="collect($brands)"
                      chooseOptionText="Select an Attribute" autocomplete="default_variant.brand_id"
                      wire:model="default_variant.brand_id" /> --}}
                    {{-- <x-input-error :messages="$errors->get('opening_hours.' . $dayOfWeek . '.opens_at')" /> --}}
                  </td>
                  <td class="px-6 py-4">
                    <x-td-action-button class="cursor-pointer">
                      <x-icons.trash class="w-5 h-5"
                        wire:click="{{ $idx > 0 ? 'deleteAttributeFromOtherVariant(' . $idx - 1 . ',' . $attribute_idx . ')' : 'deleteAttributeFromDefaultVariant(' . $attribute_idx . ')' }}" />
                    </x-td-action-button>
                  </td>
                </tr>
              @empty
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                  <td class="px-6 py-4 text-center" colspan="3">
                    {{ __('No attributes added yet.') }}
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <x-outline-button type="button" class="mt-6"
          wire:click="{{ $idx > 0 ? 'addAttributeToOtherVariant(' . $idx - 1 . ')' : 'addAttributeToDefaultVariant' }}">Add
          an
          attribute</x-outline-button>
      </div>
    @endforeach

    <x-default-button class="mt-6">{{ __('Save All') }}</x-default-button>
  </form>
</section>
