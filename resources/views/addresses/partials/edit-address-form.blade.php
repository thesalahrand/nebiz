<section class="w-full max-w-3xl">
  <form method="post" action="{{ route('addresses.update', $address->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <h5 class="text-xl font-semibold text-gray-900 dark:text-white"> {{ __('Edit Address') }} </h5>

    <div class="mt-6">
      <div>
        <x-input-label for="label" :value="__('Label')" required="true" />
        <x-text-input id="label" name="label" type="text" :value="old('label', $address->label)" required autofocus
          autocomplete="label" maxlength="255" placeholder="{{ __('New Ghoroa Restaurant') }}" />
        <x-input-error :messages="$errors->get('label')" />
      </div>
    </div>

    <div class="mt-6" x-data="geoLocationPicker(@js(old('latitude', $address->latitude)) || geoLocation.latitude, @js(old('longitude', $address->longitude)) || geoLocation.longitude)">
      <div id="map" class="h-80"></div>
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6">
        <div>
          <x-input-label for="latitude" :value="__('Latitude')" required="true" />
          <x-text-input id="latitude" name="latitude" type="number" x-model.number="geoLocation.latitude"
            autocomplete="latitude" min="-90" max="90" step="0.00000001" @input.debounce="update"
            placeholder="{{ __('22.7413') }}" />
          <x-input-error :messages="$errors->get('latitude')" />
        </div>
        <div>
          <x-input-label for="longitude" :value="__('Longitude')" required="true" />
          <x-text-input id="longitude" name="longitude" type="number" x-model.number="geoLocation.longitude"
            autocomplete="longitude" min="-180" max="180" step="0.00000001" @input.debounce="update"
            placeholder="{{ __('80.4357') }}" />
          <x-input-error :messages="$errors->get('longitude')" />
        </div>
      </div>
      <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">
        {{ __('This is initially filled as per your current geolocation. You may set your geolocation manually or clicking the most accurate position from the map above.') }}
      </div>
    </div>

    <div class="flex items-start mt-6">
      <div class="flex items-start">
        <div class="flex items-center h-5">
          <x-checkbox-input id="is_current" name="is_current" :checked="old('is_current', $address->is_current)" />
        </div>
        <x-input-label for="is_current" :value="__('Set as Current Address?')" class="ms-2 mb-0" />
      </div>
    </div>

    <x-default-button class="mt-6">{{ __('Save') }}</x-default-button>
  </form>
</section>
