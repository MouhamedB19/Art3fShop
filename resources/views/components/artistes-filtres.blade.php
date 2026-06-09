<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<div>
    {{-- Fil d'Ariane --}}
    @section('breadcrumb')
        <a href="{{ route('home') }}" class="hover:text-[#E8490F] transition-colors">Accueil</a>
        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <a href="{{ route('artistes.index') }}" class="hover:text-[#E8490F] transition-colors">Artistes</a>
        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        
        <span class="text-[#1A1A1A] font-medium truncate max-w-[200px]">
            @if($artiste->nom_d_artiste)
                {{ $artiste->nom_d_artiste }}
            @else
                {{ $artiste->user->nom }}
        </span>
    @endsection

    @section('content')
        
    @endsection
</div>