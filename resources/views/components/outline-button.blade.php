@props([
    'color' => 'blue',
    'type' => 'submit',
])

@php
  if ($color == 'blue') {
      $classes = 'text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-[9px] text-center dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800';
  }
@endphp

<button {{ $attributes->merge(['type' => $type, 'class' => $classes]) }}>
  {{ $slot }}
</button>
