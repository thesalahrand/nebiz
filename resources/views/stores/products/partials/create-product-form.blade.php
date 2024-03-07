<section class="w-full max-w-3xl">
  <form method="post" action="{{ route('stores.store') }}" enctype="multipart/form-data" x-data="{
      skus: [{
          name: '',
          brandId: '',
          unitName: '',
          price: '',
          quantity: '',
          image: '',
          additionalText: ''
      }],
      currSkuIdx: 0
  }">
    @csrf

    <h5 class="text-xl font-semibold text-gray-900 dark:text-white"> {{ __('Create a Product') }} </h5>

    <div
      class="text-sm font-medium text-center text-gray-500 border-b border-gray-200 dark:text-gray-400 dark:border-gray-700 mt-6">
      <ul class="flex flex-wrap -mb-px">
        <template x-for="(sku, idx) in skus">
          <li class="me-2">
            <a class="inline-flex items-center p-4 border-b-2 rounded-t-lg cursor-pointer"
              :class="{
                  'text-blue-600 border-blue-600 active dark:text-blue-500 dark:border-blue-500': idx ===
                      currSkuIdx,
                  'border-transparent hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300': idx !==
                      currSkuIdx
              }">
              <span x-text="`Variant #${idx + 1}`" @click="currSkuIdx = idx"></span>
              <template x-if="idx !== 0">
                <x-icons.close class="w-2 h-2 ms-4" @click="skus.splice(idx, 1); currSkuIdx = 0;" />
              </template>
            </a>
          </li>
        </template>
        <li class="me-2">
          <a class="inline-flex items-center p-4 border-b-2 border-transparent rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300 cursor-pointer"
            @click="skus.push({price: '', quantity: '', image: ''})">
            <x-icons.plus class="w-4 h-4 me-2 -mt-1" />
            {{ __('Add') }}
          </a>
        </li>
      </ul>
    </div>

    <template x-for="(sku, idx) in skus">
      <div x-show="idx === currSkuIdx">
        <template x-if="idx === 0">
          <div class="mt-6">
            <x-input-label for="name" :value="__('Name')" required="true" />
            <x-text-input id="name" name="name" type="text" :value="old('name')" required autofocus
              autocomplete="name" maxlength="255" x-model="sku.name" />
            <x-input-error :messages="$errors->get('name')" />
          </div>
        </template>

        <template x-if="idx === 0">
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6">
            <div>
              <x-input-label for="brand_id" :value="__('Brand')" />
              <x-select-input id="brand_id" name="brand_id" :options="$brands" chooseOptionText="Select a Brand"
                :selectedOptionValue="old('brand_id')" autocomplete="brand_id" x-model="sku.brandId" />
              <x-input-error :messages="$errors->get('brand_id')" />
            </div>
            <div>
              <x-input-label for="unit_name" :value="__('Unit Name')" required="true" />
              <x-select-input id="unit_name" name="unit_name" :options="App\Enums\Unit::toCollection()" chooseOptionText="Select a unit name"
                :selectedOptionValue="old('unit_name')" autocomplete="unit_name" x-model="sku.unitName" />
              <x-input-error :messages="$errors->get('unit_name')" />
            </div>
          </div>
        </template>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6">
          <div>
            <x-input-label for="price" :value="__('Price')" />
            <x-text-input id="price" name="price" type="number" :value="old('price')" step="0.01"
              autocomplete="price" maxlength="255" x-model="sku.price" />
            <x-input-error :messages="$errors->get('price')" />
          </div>
          <div>
            <x-input-label for="quantity" :value="__('Stock Quantity')" />
            <x-text-input id="quantity" name="quantity" type="number" :value="old('quantity')" step="0.01"
              autocomplete="quantity" maxlength="255" x-model="sku.quantity" />
            <x-input-error :messages="$errors->get('quantity')" />
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6">
          <div x-data="imageViewer(@js(asset('images/placeholder-image.png')))">
            <x-input-label for="image" :value="__('Image')" />
            <x-file-input id="image" name="image" type="file" accept=".jpg, .jpeg" x-model="sku.image"
              @change="fileChosen" />
            <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">
              {{ __('The image must be in JPG format (max 1 MB).') }}</div>
            <x-input-error :messages="$errors->get('image')" />
            <img :src="imageUrl" class="rounded mt-2 w-16 object-cover" alt="product-image">
          </div>
          <template x-if="idx === 0">
            <div>
              <x-input-label for="additional_info" :value="__('Write more about your store')" />
              <x-textarea-input rows="9" id="additional_info" name="additional_info"
                autocomplete="additional_info" maxlength="1000"
                placeholder="{{ __('Additional information about your store..') }}"
                x-model="sku.additionalText">{{ old('additional_info') }}</x-textarea-input>
              <x-input-error :messages="$errors->get('additional_info')" />
            </div>
          </template>
        </div>
      </div>
    </template>

    <x-default-button class="mt-6">{{ __('Save All') }}</x-default-button>
  </form>
</section>
