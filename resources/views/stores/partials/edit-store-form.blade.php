<section class="w-full max-w-3xl">
  <form method="post" action="{{ route('stores.update', $store->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <h5 class="text-xl font-semibold text-gray-900 dark:text-white"> {{ __('Edit Store') }} </h5>

    <div class="mt-6">
      <div>
        <x-input-label for="name" :value="__('Name')" required="true" />
        <x-text-input id="name" name="name" type="text" :value="old('name', $store->name)" required autofocus
          autocomplete="name" maxlength="255" placeholder="{{ __('New Ghoroa Restaurant') }}" />
        <x-input-error :messages="$errors->get('name')" />
      </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6">
      <div>
        <x-input-label for="address" :value="__('Address')" required="true" />
        <x-text-input id="address" name="address" type="text" :value="old('address', $store->address)" required autocomplete="address"
          placeholder="{{ __('444 K.B. Hemayet Uddin Rd') }}" maxlength="255" />
        <x-input-error :messages="$errors->get('address')" />
      </div>
      <div>
        <x-input-label for="store_type_id" :value="__('Type')" required="true" />
        <x-select-input id="store_type_id" name="store_type_id" :options="$types" chooseOptionText="Select a Type"
          :selectedOptionValue="old('store_type_id', $store->store_type_id)" required autocomplete="store_type_id" />
        <x-input-error :messages="$errors->get('store_type_id')" />
      </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6">
      <div>
        <x-input-label for="area" :value="__('Area')" />
        <x-text-input id="area" name="area" type="text" :value="old('area', $store->area)" autocomplete="area"
          placeholder="{{ __('Hemayet Uddin Rd') }}" maxlength="255" />
        <x-input-error :messages="$errors->get('area')" />
      </div>
      <div>
        <x-input-label for="city" :value="__('City')" />
        <x-text-input id="city" name="city" type="text" :value="old('city', $store->city)" autocomplete="city"
          placeholder="{{ __('Barishal') }}" maxlength="255" />
        <x-input-error :messages="$errors->get('city')" />
      </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6">
      <div>
        <x-input-label for="postal_code" :value="__('Postal Code')" />
        <x-text-input id="postal_code" name="postal_code" type="text" :value="old('postal_code', $store->postal_code)" autocomplete="postal_code"
          placeholder="{{ __('8200') }}" maxlength="255" />
        <x-input-error :messages="$errors->get('postal_code')" />
      </div>
      <div>
        <x-input-label for="phone" :value="__('Phone')" required="true" />
        <div class="relative">
          <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none text-sm">
            +880
          </div>
          <x-text-input id="phone" type="tel" name="phone" class="ps-14" :value="old('phone', $store->phone)" required
            autocomplete="phone" maxlength="10" pattern="\d+" placeholder="{{ __('1234567890') }}"
            title="Valid Bangladeshi mobile number excluding +880" />
        </div>
        <x-input-error :messages="$errors->get('phone')" />
      </div>
    </div>


    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6">
      <div>
        <x-input-label for="email" :value="__('Email')" />
        <x-text-input id="email" name="email" type="email" :value="old('email', $store->email)" autocomplete="email"
          maxlength="255" placeholder="{{ __('test@exampl.com') }}" />
        <x-input-error :messages="$errors->get('email')" />
      </div>
      <div>
        <x-input-label for="website" :value="__('Website')" />
        <x-text-input id="website" name="website" type="url" :value="old('website', $store->website)" autocomplete="website"
          maxlength="255" placeholder="{{ __('https://example.com') }}" />
        <x-input-error :messages="$errors->get('website')" />
      </div>
    </div>

    <div class="mt-6" x-data="geoLocationPicker(@js(old('latitude', $store->latitude)) || geoLocation.latitude, @js(old('longitude', $store->longitude)) || geoLocation.longitude)">
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
        {{ __('This is initially filled as per your current geolocation. You may set your shops\'s geolocation manually or clicking the most accurate position from the map above.') }}
      </div>
    </div>

    <div class="mt-6">

    </div>
    <div class="relative overflow-x-auto">
      <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
          <tr>
            <th scope="col" class="px-6 py-3">
              {{ __('Weekday') }}
            </th>
            <th scope="col" class="px-6 py-3">
              {{ __('Closed?') }}
            </th>
            <th scope="col" class="px-6 py-3">
              {{ __('Opens at') }}
            </th>
            <th scope="col" class="px-6 py-3">
              {{ __('Closes at') }}
            </th>
          </tr>
        </thead>
        <tbody>
          @for ($dayOfWeek = 0; $dayOfWeek < 7; $dayOfWeek++)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700" x-data="{ isClosed: Boolean(@js(old('opening_hours.' . $dayOfWeek . '.is_closed', $store->openingHours[$dayOfWeek]->is_closed))), opensAt: @js(old('opening_hours.' . $dayOfWeek . '.opens_at', $store->openingHours[$dayOfWeek]->opens_at)), closesAt: @js(old('opening_hours.' . $dayOfWeek . '.closes_at', $store->openingHours[$dayOfWeek]->closes_at)) }">
              <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                {{ now()->setDaysFromStartOfWeek($dayOfWeek)->format('l') }}
              </th>
              <td class="px-6 py-4">
                <x-checkbox-input name="opening_hours[{{ $dayOfWeek }}][is_closed]"
                  autocomplete="is_closed_{{ $dayOfWeek }}" x-model="isClosed" />
                <x-input-error :messages="$errors->get('opening_hours.' . $dayOfWeek . '.is_closed')" />
              </td>
              <td class="px-6 py-4">
                <x-text-input type="time" name="opening_hours[{{ $dayOfWeek }}][opens_at]"
                  autocomplete="opens_at_{{ $dayOfWeek }}" x-bind:disabled="isClosed"
                  x-bind:value="isClosed ? null : opensAt" />
                <x-input-error :messages="$errors->get('opening_hours.' . $dayOfWeek . '.opens_at')" />
              </td>
              <td class="px-6 py-4">
                <x-text-input type="time" name="opening_hours[{{ $dayOfWeek }}][closes_at]"
                  autocomplete="closes_at_{{ $dayOfWeek }}" x-bind:disabled="isClosed"
                  x-bind:value="isClosed ? null : closesAt" />
                <x-input-error :messages="$errors->get('opening_hours.' . $dayOfWeek . '.closes_at')" />
              </td>
            </tr>
          @endfor
        </tbody>
      </table>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6">
      <div x-data="imageViewer(@js($store->getFirstMediaUrl('store-covers', 'thumb') ?: asset('images/placeholder-image.png')))">
        <x-input-label for="cover" :value="__('Cover Image')" />
        <x-file-input id="cover" name="cover" type="file" accept=".jpg, .jpeg" @change="fileChosen" />
        <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">
          {{ __('The cover image must be in JPG format (max 1 MB).') }}</div>
        <x-input-error :messages="$errors->get('cover')" />
        <img :src="imageUrl" class="rounded mt-2 w-16 object-cover" alt="store-cover-image">
      </div>
      <div>
        <x-input-label for="additional_info" :value="__('Write more about your store')" />
        <x-textarea-input rows="9" id="additional_info" name="additional_info" autocomplete="additional_info"
          maxlength="1000"
          placeholder="{{ __('Additional information about your store..') }}">{{ old('additional_info', $store->additional_info) }}</x-textarea-input>
        <x-input-error :messages="$errors->get('additional_info')" />
      </div>
    </div>

    <x-default-button class="mt-6">{{ __('Save') }}</x-default-button>
  </form>
</section>
