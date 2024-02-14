@props(['strokeWidth' => 2])

<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" stroke-width="{{ $strokeWidth }}"
  viewBox="0 0 6 10" {{ $attributes }}>
  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="m1 9 4-4-4-4" />
</svg>
