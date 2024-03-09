<section class="w-full max-w-3xl">
  <form method="post" action="{{ route('stores.products.store', $store->id) }}" enctype="multipart/form-data"
    x-data="{
        currVariantIdx: 0,
        variants: @js($variants),
        getErrorsAsHtml(errors) {
            return errors.length ? `<ul class='mt-2 text-sm text-red-600 dark:text-red-500 space-y-1'>
                                    ${errors.map(error => ('<li>' + error + '</li>')).join('')}
                                </ul>` : ''
        }
    }">
    @csrf

    <h5 class="text-xl font-semibold text-gray-900 dark:text-white"> {{ __('Create a Product') }} </h5>

    <div
      class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700 mt-6">
      <ul class="flex flex-wrap -mb-px">
        <template x-for="(variant, idx) in variants">
          <li class="me-2">
            <a class="inline-flex items-center p-4 border-b-2 rounded-t-lg cursor-pointer"
              :class="{
                  'text-blue-600 border-blue-600 active dark:text-blue-500 dark:border-blue-500': idx ===
                      currVariantIdx,
                  'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300': idx !==
                      currVariantIdx
              }">
              <span x-text="`Variant #${idx + 1}`" @click="currVariantIdx = idx"></span>
              <template x-if="idx !== 0">
                <x-icons.close class="w-2 h-2 ms-4" @click="variants.splice(idx, 1); currVariantIdx = 0;" />
              </template>
            </a>
          </li>
        </template>
        <li class="me-2">
          <a class="inline-flex items-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 cursor-pointer"
            @click="variants.push({price: {value: '', errors: []}, quantity: {value: '', errors: []}, image: {value: '', errors: []}})">
            <x-icons.plus class="w-4 h-4 me-2 -mt-1" />
            {{ __('Add') }}
          </a>
        </li>
      </ul>
    </div>

    <template x-for="(variant, idx) in variants">
      <div x-show="idx === currVariantIdx">
        <template x-if="idx === 0">
          <div class="mt-6">
            <x-input-label for="default_variant_name" :value="__('Name')" required="true" />
            <x-text-input id="default_variant_name" name="default_variant[name]" type="text" required autofocus
              autocomplete="default_variant_name" maxlength="255" x-model="variant.name.value" />
            <x-input-error :messages="$errors->get('name')" />
            <div x-html="getErrorsAsHtml(variant.name.errors)"></div>
          </div>
        </template>

        <template x-if="idx === 0">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6">
            <div>
              <x-input-label for="default_variant_brand_id" :value="__('Brand')" />
              <x-select-input id="default_variant_brand_id" name="default_variant[brand_id]" :options="$brands"
                chooseOptionText="Select a Brand" autocomplete="default_variant_brand_id"
                x-model="variant.brand_id.value" />
              <div x-html="getErrorsAsHtml(variant.brand_id.errors)"></div>
            </div>
            <div>
              <x-input-label for="default_variant_unit_name" :value="__('Unit Name')" required="true" />
              <x-select-input id="default_variant_unit_name" name="default_variant[unit_name]" :options="App\Enums\Unit::toCollection()"
                chooseOptionText="Select a unit name" autocomplete="default_variant_unit_name"
                x-model="variant.unit_name.value" />
              <div x-html="getErrorsAsHtml(variant.unit_name.errors)"></div>
            </div>
          </div>
        </template>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6">
          <div>
            <x-input-label x-bind:for="idx > 0 ? `other_variants_${idx - 1}_price` : 'default_variant_price'"
              :value="__('Price')" />
            <x-text-input x-bind:id="idx > 0 ? `other_variants_${idx - 1}_price` : 'default_variant_price'"
              x-bind:name="idx > 0 ? `other_variants[${idx - 1}][price]` : 'default_variant[price]'" type="number"
              step="0.01" x-bind:autocomplete="idx > 0 ? `other_variants_${idx - 1}_price` : 'default_variant_price'"
              min="0" max="999999.99" x-model="variant.price.value" />
            <div x-html="getErrorsAsHtml(variant.price.errors)"></div>
          </div>
          <div>
            <x-input-label x-bind:for="idx > 0 ? `other_variants_${idx - 1}_quantity` : 'default_variant_quantity'"
              :value="__('Stock Quantity')" />
            <x-text-input x-bind:id="idx > 0 ? `other_variants_${idx - 1}_quantity` : 'default_variant_quantity'"
              x-bind:name="idx > 0 ? `other_variants[${idx - 1}][quantity]` : 'default_variant[quantity]'"
              type="number" step="0.01"
              x-bind:autocomplete="idx > 0 ? `other_variants_${idx - 1}_quantity` : 'default_variant_quantity'"
              min="0" max="999999.99" x-model="variant.quantity.value" />
            <div x-html="getErrorsAsHtml(variant.quantity.errors)"></div>
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6">
          <div x-data="imageViewer(@js(asset('images/placeholder-image.png')))">
            <x-input-label x-bind:for="idx > 0 ? `other_variants_${idx - 1}_image` : 'default_variant_image'"
              :value="__('Image')" />
            <x-file-input x-bind:id="idx > 0 ? `other_variants_${idx - 1}_image` : 'default_variant_image'"
              x-bind:name="idx > 0 ? `other_variants[${idx - 1}][image]` : 'default_variant[image]'" type="file"
              accept=".jpg, .jpeg" x-model="variant.image.value" @change="fileChosen" />
            <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">
              {{ __('The image must be in JPG format (max 1 MB).') }}</div>
            <div x-html="getErrorsAsHtml(variant.image.errors)"></div>
            <img :src="imageUrl" class="rounded mt-2 w-16 object-cover" alt="product-image">
          </div>
          <template x-if="idx === 0">
            <div>
              <x-input-label for="default_variant_additional_info" :value="__('Write more about your store')" />
              <x-textarea-input rows="9" id="default_variant_additional_info"
                name="default_variant[additional_info]" autocomplete="additional_info" maxlength="1000"
                placeholder="{{ __('Additional information about your store..') }}"
                x-model="variant.additional_info.value"></x-textarea-input>
              <div x-html="getErrorsAsHtml(variant.additional_info.errors)"></div>
            </div>
          </template>
        </div>
      </div>
    </template>

    <x-default-button class="mt-6">{{ __('Save All') }}</x-default-button>
  </form>
</section>
