<section class="w-full max-w-3xl">
  <form method="post" action="{{ route('stores.services.store', $store->id) }}" enctype="multipart/form-data">
    @csrf

    <h5 class="text-xl font-semibold text-gray-900 dark:text-white"> {{ __('Create a Service') }} </h5>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6">
      <div>
        <x-input-label for="name" :value="__('Name')" required="true" />
        <x-text-input id="name" name="name" type="text" :value="old('name')" required autofocus
          autocomplete="name" maxlength="255" />
        <x-input-error :messages="$errors->get('name')" />
      </div>
      <div>
        <x-input-label for="price" :value="__('Price')" />
        <x-text-input id="price" name="price" type="number" :value="old('price')" step="0.01" autocomplete="price"
          min="0" max="999999.99" />
        <x-input-error :messages="$errors->get('price')" />
      </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6">
      <div>
        <x-input-label for="duration" :value="__('Duration')" />
        <x-text-input id="duration" name="duration" type="number" :value="old('duration')" step="0.01"
          autocomplete="duration" min="0" max="999999.99" />
        <x-input-error :messages="$errors->get('duration')" />
      </div>
      <div>
        <x-input-label for="duration_unit_name" :value="__('Duration Unit Name')" />
        <x-select-input id="duration_unit_name" name="duration_unit_name" :options="App\Enums\DurationUnit::toCollection()"
          chooseOptionText="Select a unit name" :selectedOptionValue="old('duration_unit_name')" autocomplete="duration_unit_name" />
        <x-input-error :messages="$errors->get('duration_unit_name')" />
      </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6">
      <div x-data="imageViewer(@js(asset('images/placeholder-image.png')))">
        <x-input-label for="image" :value="__('Cover Image')" />
        <x-file-input id="image" name="image" type="file" accept=".jpg, .jpeg" @change="fileChosen" />
        <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">
          {{ __('The image must be in JPG format (max 1 MB).') }}</div>
        <x-input-error :messages="$errors->get('image')" />
        <img :src="imageUrl" class="rounded mt-2 w-16 object-cover" alt="service-image">
      </div>
      <div>
        <x-input-label for="additional_info" :value="__('Write more about your store')" />
        <x-textarea-input rows="9" id="additional_info" name="additional_info" autocomplete="additional_info"
          maxlength="1000"
          placeholder="{{ __('Additional information about your store..') }}">{{ old('additional_info') }}</x-textarea-input>
        <x-input-error :messages="$errors->get('additional_info')" />
      </div>
    </div>

    <x-default-button class="mt-6">{{ __('Save') }}</x-default-button>
  </form>
</section>
