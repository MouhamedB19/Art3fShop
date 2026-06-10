@extends('layouts.app')

@section('title', $artiste->user->prenom . $artiste->user->nom)


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
        @endif
    </span>
@endsection


@section('content')
    @php
        $nomArtiste = $artiste->nom_d_artiste ?? $artiste->user->nom;
        $ville      = $artiste->localisation?->ville?->nom_ville;
        $pays       = $artiste->localisation?->ville?->pays?->nom_pays;
    @endphp
 
    {{-- ═══════════════════════════════════════════════════
         BANDEAU PHOTO FULL-WIDTH
             ═══════════════════════════════════════════════════ --}}
    <div class="relative w-full h-72 md:h-96 overflow-hidden bg-gray-900">
    
        {{-- Photo de fond --}}
        @if($artiste->photo)
            <img src="{{ asset('storage/' . $artiste->photo) }}"
                 alt="{{ $nomArtiste }}"
                 class="w-full h-full object-cover object-top opacity-60">
        @else
            <div class="w-full h-full bg-gradient-to-br from-gray-800 to-gray-900"></div>
        @endif
    
        {{-- Overlay dégradé --}}
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
    
        {{-- Infos sur le bandeau --}}
        <div class="absolute bottom-0 left-0 right-0 p-6 md:p-10">
            <div class="max-w-screen-xl mx-auto flex items-end justify-between gap-4">
                <div>
                    {{-- Catégories --}}
                    @if($artiste->categories?->count())
                        <div class="flex gap-2 mb-2">
                            @foreach($artiste->categories->take(3) as $cat)
                                <span class="text-xs text-gray-300 bg-white/10 px-2 py-0.5 rounded">
                                    {{ $cat->nom_categorie }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                    
                    {{-- Nom --}}
                    <h1 class="text-3xl md:text-5xl font-black text-white uppercase tracking-wide">
                        {{ $nomArtiste }}
                    </h1>
                
                    {{-- Localisation --}}
                    @if($ville || $pays)
                        <p class="text-gray-300 text-sm mt-2">
                            {{ collect([$ville, $pays])->filter()->implode(', ') }}
                        </p>
                    @endif
                    
                    {{-- Picto art3f --}}
                    @if($artiste->Est_Artiste_Art3f)
                        <span class="inline-flex items-center gap-1.5 mt-2 text-xs
                                     text-[#E8490F] font-semibold bg-white/10 px-2 py-0.5 rounded">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#E8490F]"></span>
                            Artiste art3f
                        </span>
                    @endif
                </div>
            
                {{-- Nombre d'œuvres + suivre --}}
                <div class="shrink-0 text-right hidden md:block">
                    <p class="text-white text-sm">
                        <span class="font-bold text-2xl">{{ $artiste->oeuvres->count() }}</span>
                        œuvre{{ $artiste->oeuvres->count() > 1 ? 's' : '' }} en ligne
                    </p>
                    @auth
                        <button class="mt-2 flex items-center gap-2 text-xs font-bold text-white
                                       border border-white/30 hover:border-white px-4 py-2 rounded-lg
                                       transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 4v16m8-8H4"/>
                            </svg>
                            Suivre cet artiste
                        </button>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════
         BARRE INFOS + RÉSEAUX SOCIAUX
         ═══════════════════════════════════════════════════ --}}
    <div class="border-b border-gray-200 bg-white">
        <div class="relative max-w-screen-xl mx-auto px-4" x-data="{ onglet: null }">
            <div class="flex items-center justify-between h-12">
            
                {{-- Onglets accordéon --}}
                <div class="flex items-center gap-1">
                    @foreach(['bio' => 'L\'artiste', 
                            'formation' => 'Formation', 
                            'expositions' => 'Expositions'
                            ] as $key => $label)
                        
                        <button @click="onglet = onglet === '{{ $key }}' ? null : '{{ $key }}'"
                                class="px-4 py-3 text-sm font-medium transition-colors border-b-2
                                       :class onglet === '{{ $key }}'
                                           ? 'border-[#E8490F] text-[#E8490F]'
                                           : 'border-transparent text-gray-500 hover:text-[#1A1A1A]'">
                            {{ $label }}
                            <svg class="inline w-3 h-3 ml-1 transition-transform"
                                 :class="onglet === '{{ $key }}' ? 'rotate-180' : ''"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
    
                    @endforeach    
                </div>
  
            </div>
            {{-- Contenu accordéon --}}
            <div x-show="onglet !== null"
                 x-transition
                 class="absolute top-auto left-0 right-0 bg-white border-b border-gray-200
                        shadow-lg z-30">
                <div class="max-w-screen-xl mx-auto px-4 py-6">
                    <div x-show="onglet === 'bio'">
                        <p class="text-gray-600 leading-relaxed max-w-3xl">
                            {{ $artiste->bio ?? 'Biographie non renseignée.' }}
                        </p>
                        
                    </div>
                    <div x-show="onglet === 'formation'">
                        @if($artiste->CV)
                            <div class="flex items-center gap-4">
                                <svg class="w-8 h-8 text-red-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                          d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0
                                             01 13.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5
                                             3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504
                                             1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0
                                             00-9-9z"/>
                                </svg>
                                <div>
                                    <p class="text-sm font-semibold text-[#1A1A1A]">CV de l'artiste</p>
                                    <p class="text-xs text-gray-400 mt-0.5">Formation, expositions, prix et récompenses</p>
                                </div>
                                <a href="{{ asset('storage/' . $artiste->CV) }}"
                                   target="_blank"
                                   class="ml-auto px-4 py-2 bg-[#1A1A1A] hover:bg-[#E8490F] text-white
                                          text-xs font-bold rounded-lg transition-colors">
                                    Télécharger le CV
                                </a>
                            </div>
                        @else
                            <p class="text-gray-400 text-sm">CV non renseigné.</p>
                        @endif
                    </div>
                    <div x-show="onglet === 'expositions'">
                        @if($artiste->CV)
                            <p class="text-gray-500 text-sm">
                                Les informations sur les expositions sont disponibles dans le CV de l'artiste.
                            </p>
                            <a href="{{ asset('storage/' . $artiste->CV) }}" target="_blank"
                               class="inline-flex items-center gap-1 mt-3 text-sm text-[#E8490F] hover:underline font-medium">
                                Consulter le CV →
                            </a>
                        @else
                            <p class="text-gray-400 text-sm">Expositions non renseignées.</p>
                        @endif
                    </div>
                </div>
            </div>
                    
                    
                    
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════
     GALERIE DES ŒUVRES
     ═══════════════════════════════════════════════════ --}}
    <div class="max-w-screen-xl mx-auto px-4 py-10">
    
        @if($artiste->oeuvres->count() > 0)
            <div class="columns-2 md:columns-3 lg:columns-4 gap-4">
                @foreach($artiste->oeuvres as $oeuvre)
                    @php
                        $tirage  = $oeuvre->tirages->first();
                        $vendue  = $tirage?->status === 'vendu';
                        $isNew   = $oeuvre->created_at->diffInDays(now()) <= 30;
                        $prix    = $tirage?->prix ?? 0;
                        $prixAffiche = $oeuvre->taux_reduction
                            ? $prix * (1 - $oeuvre->taux_reduction)
                            : $prix;
                    @endphp
                    <x-carte-oeuvre 
                        :oeuvre="$oeuvre" 
                        :tirage="$tirage"
                        :vendue="$vendue"
                        :isNew="$isNew"
                        :prix="$prix" 
                        :prixAffiche="$prixAffiche"
                    />

                @endforeach    
        
        @else
            <div class="text-center py-24">
                <p class="text-xl font-bold text-gray-300">Aucune œuvre disponible</p>
            </div>
        @endif
        
    </div>
@endsection