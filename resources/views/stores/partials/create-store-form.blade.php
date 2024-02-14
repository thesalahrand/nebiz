<section class="w-full max-w-3xl">
  <form method="post" action="{{ route('stores.store') }}" enctype="multipart/form-data">
    @csrf

    <h5 class="text-xl font-semibold text-gray-900 dark:text-white"> {{ __('Create a Store') }} </h5>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6">
      <div>
        <x-input-label for="name" :value="__('Name')" required="true" />
        <x-text-input id="name" name="name" type="text" :value="old('name')" required autofocus
          autocomplete="name" maxlength="255" />
        <x-input-error :messages="$errors->get('name')" />
      </div>
      <div>
        <x-input-label for="address" :value="__('Address')" required="true" />
        <x-text-input id="address" name="address" type="text" :value="old('address')" required autocomplete="address"
          placeholder="{{ __('444 K.B. Hemayet Uddin Rd') }}" maxlength="255" />
        <x-input-error :messages="$errors->get('address')" />
      </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6">
      <div>
        <x-input-label for="area" :value="__('Area')" />
        <x-text-input id="area" name="area" type="text" :value="old('area')" autocomplete="area"
          placeholder="{{ __('Hemayet Uddin Rd') }}" maxlength="255" />
        <x-input-error :messages="$errors->get('area')" />
      </div>
      <div>
        <x-input-label for="city" :value="__('City')" />
        <x-text-input id="city" name="city" type="text" :value="old('city')" autocomplete="city"
          placeholder="{{ __('Barishal') }}" maxlength="255" />
        <x-input-error :messages="$errors->get('city')" />
      </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6">
      <div>
        <x-input-label for="postal_code" :value="__('Postal Code')" />
        <x-text-input id="postal_code" name="postal_code" type="text" :value="old('postal_code')" autocomplete="postal_code"
          placeholder="{{ __('8200') }}" maxlength="255" />
        <x-input-error :messages="$errors->get('postal_code')" />
      </div>
      <div>
        <x-input-label for="phone" :value="__('Phone')" required="true" />
        <div class="relative">
          <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none text-sm">
            +880
          </div>
          <x-text-input id="phone" type="tel" name="phone" class="ps-14" :value="old('phone')" required
            autocomplete="phone" maxlength="10" pattern="\d+" title="Valid Bangladeshi mobile number excluding +880" />
        </div>
        <x-input-error :messages="$errors->get('phone')" />
      </div>
    </div>


    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6">
      <div>
        <x-input-label for="email" :value="__('Email')" />
        <x-text-input id="email" name="email" type="email" :value="old('email')" autocomplete="email"
          maxlength="255" />
        <x-input-error :messages="$errors->get('email')" />
      </div>
      <div>
        <x-input-label for="website" :value="__('Website')" />
        <x-text-input id="website" name="website" type="url" :value="old('website')" autocomplete="website"
          maxlength="255" />
        <x-input-error :messages="$errors->get('website')" />
      </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6">
      <div>
        <x-input-label for="latitude" :value="__('Latitude')" required="true" />
        <x-text-input id="latitude" name="latitude" type="number" :value="old('latitude')" autocomplete="latitude"
          min="-90" max="90" />
        <x-input-error :messages="$errors->get('latitude')" />
      </div>
      <div>
        <x-input-label for="longitude" :value="__('Longitude')" required="true" />
        <x-text-input id="longitude" name="longitude" type="number" :value="old('longitude')" autocomplete="longitude"
          min="-180" max="180" />
        <x-input-error :messages="$errors->get('longitude')" />
      </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6">
      <div x-data="imageViewer(@js(asset('images/placeholder-image.png')))">
        <x-input-label for="cover" :value="__('Cover Image')" />
        <x-file-input id="cover" name="cover" type="file" accept=".jpg, .jpeg" @change="fileChosen" />
        <div class="mt-1 text-sm text-gray-500 dark:text-gray-300">
          {{ __('The cover image must be in JPG format (max 1 MB).') }}</div>
        <x-input-error :messages="$errors->get('cover')" />
        <img :src="imageUrl" class="rounded mt-2 w-16 object-cover" alt="store-cover-image">
      </div>
      <div>
        <x-input-label for="additional_info" :value="__('Write more about your store')" />
        <x-textarea-input rows="9" id="additional_info" name="additional_info" autocomplete="additional_info"
          maxlength="1000">{{ old('additional_info') }}</x-textarea-input>
        <x-input-error :messages="$errors->get('additional_info')" />
      </div>
    </div>

    <x-default-button class="mt-6">{{ __('Save') }}</x-default-button>
  </form>
</section>
