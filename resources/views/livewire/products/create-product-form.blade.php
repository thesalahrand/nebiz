<div>
  <form method="post" wire:submit="save">
    <x-input-label for="default_variant.name" :value="__('Name')" />
    <x-text-input id="default_variant.name" type="text" required autofocus maxlength="255"
      wire:model="default_variant.name" />
    <x-input-error :messages="$errors->get('default_variant.name')" />
    <x-input-label for="default_variant.price" :value="__('Price')" />
    <x-text-input id="default_variant.price" type="number" required wire:model="default_variant.price" />
    <x-input-error :messages="$errors->get('default_variant.price')" />
    <div x-data="imageViewer(@js(asset('images/placeholder-image.png')))">
      <x-input-label for="default_variant.image" :value="__('Image')" />
      <x-file-input type="file" accept=".jpg, .jpeg" x-model="variant.image.value" @change="fileChosen"
        wire:model="default_variant.image" />
      <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">
        {{ __('The image must be in JPG format (max 1 MB).') }}</div>
      <x-input-error :messages="$errors->get('default_variant.image')" />
      <img :src="imageUrl" class="rounded mt-2 w-16 object-cover" alt="product-image">
    </div>

    <x-default-button class="mt-6">{{ __('Save All') }}</x-default-button>
  </form>
</div>
