@extends('layouts.app')

@section('title', 'Mes commandes')

@section('breadcrumb')
    <a href="{{ route('home')}}" class="hover:text-[#E8490F]">Accueil</a>
    <x-mini-fleche/>
    <a href="{{ route('compte.index') }}" class="hover:text-[#E8490F]">Mon compte</a>
    <x-mini-fleche/>
    <span class="text-[#1A1A1A]">Mes commandes</span>
@endsection

@section('content')
    <div class="max-w-screen-md mx-auto px-4 py-10">
    
        <h1 class="text-2xl font-semibold mb-8">Mes commandes</h1>
        
        @forelse($commandes as $commande)
            <a href="{{ route('compte.commandes.show', $commande->id) }}"
               class="flex items-center justify-between gap-4 p-5 border border-gray-200 rounded-2xl hover:border-[#E8490F] hover:shadow-md transition-all mb-4">
            
                <div class="flex items-center gap-4">
                    {{-- Miniature première œuvre --}}
                    @php 
                        $premierTirage = $commande->tirages?->first();
                        $premiereOeuvre = $premierTirage?->oeuvre; 

                    @endphp
                    @if($premiereOeuvre?->photo)
                        <img src="{{ asset('storage/' . $premiereOeuvre->photo) }}"
                             alt="{{ $premiereOeuvre->titre }}"
                             class="w-16 h-16 object-cover rounded-xl shrink-0">
                    @else
                        <div class="w-16 h-16 bg-gray-100 rounded-xl shrink-0"></div>
                    @endif
                
                    <div>
                        <p class="font-medium">Commande #{{ $commande->id }}</p>
                        <p class="text-sm text-gray-500 mt-0.5">
                            {{ $commande->date_commande->format('d/m/Y') }}
                            · {{ $commande->tirages->count() }} {{ Str::plural('œuvre', $commande->tirages->count()) }}
                        </p>
                    </div>
                </div>
            
                <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            
            </a>
        @empty
            <div class="text-center py-20 text-gray-400">
                <p class="text-lg">Aucune commande pour l'instant.</p>
            </div>
        @endforelse
        
    </div>
@endsection