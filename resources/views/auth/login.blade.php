<x-guest-layout>
  <x-auth-session-status class="mb-4" :status="session('status')" />

  <form method="POST" action="{{ route('login') }}">
    @csrf

    <h5 class="text-xl font-semibold text-gray-900 dark:text-white"> {{ __('Sign in to our platform') }} </h5>

    <div class="mt-6">
      <x-input-label for="email" :value="__('Email')" />
      <x-text-input id="email" type="text" name="email" :value="old('email')" required autofocus
        autocomplete="email-username" />
      <x-input-error :messages="$errors->get('email')" />
    </div>

    <div class="mt-6">
      <x-input-label for="password" :value="__('Password')" />
      <x-text-input id="password" type="password" name="password" required autocomplete="current-password" />
      <x-input-error :messages="$errors->get('password')" />
    </div>

    <div class="flex items-start mt-6">
      <div class="flex items-start">
        <div class="flex items-center h-5">
          <x-checkbox-input id="remember" name="remember" />
        </div>
        <x-input-label for="remember" :value="__('Remember me')" class="ms-2 mb-0" />
      </div>
      <a href="{{ route('password.request') }}"
        class="ms-auto text-sm text-blue-700 hover:underline dark:text-blue-500">Forgot Password?</a>
    </div>

    <x-default-button class="w-full mt-6">
      {{ __('Log in') }}
    </x-default-button>

    <div class="text-sm font-medium text-gray-500 dark:text-gray-300 mt-6"> {{ __('Not registered') }}? <a
        class="text-blue-700 hover:underline dark:text-blue-500"
        href="{{ route('register') }}">{{ __('Create account') }}</a></div>

    {{-- <div class="flex items-center justify-end mt-4">
        @if (Route::has('password.request'))
          <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
            href="{{ route('password.request') }}">
            {{ __('Forgot your password?') }}
          </a>
        @endif
      </div> --}}
  </form>
</x-guest-layout>
