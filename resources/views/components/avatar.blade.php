@props([
    'photo' => null,
    'alt' => '',
])

<div {{ $attributes->merge([
    'class' => 'rounded-full overflow-hidden bg-gray-100 border border-gray-200 flex-shrink-0'
]) }}>
    @if($photo)
        <img
            src="{{ Storage::url($photo) }}"
            alt="{{ $alt }}"
            class="w-full h-full object-cover"
        >
    @else
        <div class="w-full h-full flex items-center justify-center text-gray-300">
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="w-1/2 h-1/2"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.5"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                />
            </svg>
        </div>
    @endif
</div>