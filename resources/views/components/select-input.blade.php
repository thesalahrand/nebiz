@props([
    'disabled' => false,
    'options' => collect([]),
    'chooseOptionText' => 'Select an option',
    'selectedOptionValue' => '',
])

<select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' =>
        'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500',
]) !!}>
  <option value="" {{ $selectedOptionValue == '' ? 'selected' : '' }}>{{ __($chooseOptionText) }}</option>
  @foreach ($options as $option)
    <option {{ $selectedOptionValue == $option['value'] ? 'selected' : '' }} value="{{ $option['value'] }}"
      class="capitalize">
      {{ $option['name'] }}</option>
  @endforeach
</select>
