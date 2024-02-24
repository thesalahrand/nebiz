<nav
  class="bg-white dark:bg-gray-900 fixed w-full h-20 z-20 top-0 start-0 border-b border-gray-200 dark:border-gray-600">
  <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto h-full p-4">
    <a href="{{ route('home') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
      <x-icons.application-logo class="h-8 fill-current text-gray-900 dark:text-white" />
      <span class="self-center hidden font-bold sm:inline sm:text-xl whitespace-nowrap text-gray-900 dark:text-white">
        {{ config('app.name', 'Laravel') }}</span>
    </a>
    <div class="w-1/3 relative">
      <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown"
        class="w-full text-sm leading-5 font-medium text-blue-800 dark:text-blue-800 bg-blue-100 rounded-full py-2.5 px-4 flex justify-between items-center hover:bg-blue-100/50"
        type="button">
        <span x-text="`Location: ${geoLocation.placeName}`"
          class="text-left whitespace-nowrap text-ellipsis overflow-hidden"></span>
        <x-icons.arrow-down class="shrink-0 w-3.5 ms-2"></x-icons.arrow-down>
      </button>
      <div id="dropdown"
        class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-full dark:bg-gray-700">
        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
          <li>
            <a
              class="w-full inline-flex items-center cursor-pointer px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
              <x-icons.plus class="w-4 h-4 me-2 -mt-1" />
              {{ __('Add an address') }}
            </a>
          </li>
        </ul>
      </div>

    </div>
    <div class="flex items-center">
      <a href="{{ route('stores.create') }}">
        <x-outline-button>Create a Store</x-outline-button>
      </a>
      @auth
        <div>
          <button type="button"
            class="flex text-sm bg-gray-800 rounded-full md:me-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600 ms-4"
            id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown"
            data-dropdown-placement="bottom">
            <span class="sr-only">Open user menu</span>

            @if (Auth::user()->getFirstMediaUrl('profile-photos', 'avatar'))
              <img class="w-8 h-8 rounded-full object-cover"
                src="{{ Auth::user()->getFirstMediaUrl('profile-photos', 'avatar') }}" alt="user photo">
            @else
              <div
                class="relative inline-flex items-center justify-center w-8 h-8 overflow-hidden bg-blue-100 rounded-full dark:bg-blue-600">
                <span class="font-medium text-gray-600 dark:text-gray-300">{{ strtoupper(Auth::user()->name[0]) }}</span>
              </div>
            @endif
          </button>
          <div
            class="z-50 my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600 hidden"
            id="user-dropdown" data-popper-placement="bottom"
            style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(606px, 58px);">
            <div class="px-4 py-3">
              <span class="block text-sm text-gray-900 dark:text-white">{{ Auth::user()->name }}</span>
              <span class="block text-sm  text-gray-500 truncate dark:text-gray-400">{{ Auth::user()->email }}</span>
            </div>
            <ul class="py-1" aria-labelledby="user-menu-button">
              <li>
                <a href="{{ route('profile.edit') }}"
                  class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                  role="menuitem">{{ __('Edit Profile') }}</a>
              </li>
              <li>
                <a href="{{ route('stores.index') }}"
                  class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                  role="menuitem">{{ __('My Stores') }}</a>
              </li>
              <li>
                <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <a href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                        this.closest('form').submit();"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                    role="menuitem">{{ __('Sign out') }}</a>
                </form>
              </li>
            </ul>
          </div>
        </div>
      @endauth

      @guest
        <a href="{{ route('login') }}">
          <x-default-button class="ms-2">Login</x-default-button>
        </a>
      @endguest
    </div>
  </div>
</nav>
