@props(['text', 'htmlId'])

<div id="{{ $htmlId }}"
  {{ $attributes->merge(['class' => 'flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400']) }}
  role="alert">
  <div class="text-sm font-medium">
    {{ $text }}
  </div>
  <button type="button"
    class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700"
    data-dismiss-target="#{{ $htmlId }}" aria-label="Close">
    <span class="sr-only">Close</span>
    <x-icons.close class="w-3 h-3" />
  </button>
</div>
