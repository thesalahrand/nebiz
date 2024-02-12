<x-guest-layout>
  <form method="POST" action="{{ route('register') }}">
    @csrf

    <h5 class="text-xl font-semibold text-gray-900 dark:text-white"> {{ __('Sign up to our platform') }} </h5>

    <div class="mt-6">
      <x-input-label for="name" :value="__('Name')" required="true" />
      <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name"
        maxlength="255" />
      <x-input-error :messages="$errors->get('name')" />
    </div>

    <div class="mt-6">
      <x-input-label for="email" :value="__('Email')" required="true" />
      <x-text-input id="email" type="email" name="email" :value="old('email')" required autocomplete="email"
        maxlength="255" />
      <x-input-error :messages="$errors->get('email')" />
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-6 mt-6">
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
      <div>
        <x-input-label for="gender" :value="__('Gender')" required="true" />
        <x-select-input id="gender" name="gender" :options="App\Enums\Gender::toCollection()" chooseOptionText="Select a Gender"
          :selectedOption="old('gender')" required autocomplete="gender" />
        <x-input-error :messages="$errors->get('gender')" />
      </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-6 mt-6">
      <div>
        <x-input-label for="password" :value="__('Password')" required="true" />
        <x-text-input id="password" type="password" name="password" required autocomplete="new-password"
          minlength="8" />
        <x-input-error :messages="$errors->get('password')" />
      </div>
      <div>
        <x-input-label for="password_confirmation" :value="__('Confirm Password')" required="true" />
        <x-text-input id="password_confirmation" type="password" name="password_confirmation" required
          autocomplete="confirm-password" minlength="8" />
        <x-input-error :messages="$errors->get('password_confirmation')" />
      </div>
    </div>

    <x-default-button class="w-full mt-6">
      {{ __('Register') }}
    </x-default-button>

    <div class="text-sm font-medium text-gray-500 dark:text-gray-300 mt-6">{{ __('Already registered') }}? <a
        class="text-blue-700 hover:underline dark:text-blue-500" href="{{ route('login') }}">{{ __('Login now') }}</a>
    </div>
  </form>
</x-guest-layout>
