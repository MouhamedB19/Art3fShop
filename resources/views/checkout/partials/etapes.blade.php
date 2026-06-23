{{-- resources/views/checkout/partials/_etapes.blade.php --}}
@php
    $etapes = ['resume' => 'Résumé', 'identification' => 'Identification', 'adresse' => 'Adresse', 'livraison' => 'Livraison', 'paiement' => 'Paiement'];
    $actuelle = array_search($etape, array_keys($etapes));
@endphp

<div class="flex items-center justify-between mb-10 max-w-2xl mx-auto">
    @foreach($etapes as $key => $label)
        @php $index = array_search($key, array_keys($etapes)); @endphp
        <div class="flex items-center {{ !$loop->last ? 'flex-1' : '' }}">
            <div class="flex flex-col items-center">
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-medium
                    {{ $index <= $actuelle ? 'bg-[#E8490F] text-white' : 'bg-gray-100 text-gray-400' }}">
                    {{ $index + 1 }}
                </div>
                <span class="text-xs mt-1 {{ $index <= $actuelle ? 'text-[#1A1A1A]' : 'text-gray-400' }}">{{ $label }}</span>
            </div>
            @if(!$loop->last)
                <div class="flex-1 h-px mx-2 {{ $index < $actuelle ? 'bg-[#E8490F]' : 'bg-gray-200' }}"></div>
            @endif
        </div>
    @endforeach
</div>