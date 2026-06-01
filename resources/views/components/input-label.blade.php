@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-gray-700 dark:text-[#1A1A1A] text-base']) }}>
    {{ $value ?? $slot }}
</label>
