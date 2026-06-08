@extends('layouts.app')
@include('layouts.partials.header')

<nav class="max-w-screen-xl mx-auto px-4 py-3 flex items-center gap-2 text-xs text-gray-500">
    <a href="{{ route('home') }}" class="hover:text-[#E8490F] transition-colors">Accueil</a>
    
    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
    </svg>
    <span class="text-[#1A1A1A] font-medium">{{ $categorie}}s</span>
    
</nav>
@if($tiragesCorrespondants->isEmpty())
    <h1>Aucune œuvre trouvée pour cette catégorie.</h1>
@else
    <div class="overflow-hidden mx-4"> 
        <h1 class="text-lg font-bold text-[#1A1A1A] my-4">Toutes les {{$categorie}}s</h1>
        <div class="columns-2 md:columns-3 lg:columns-4 gap-4"> 
            @foreach($tiragesCorrespondants as $tirage)
                @php
                    $oeuvre = $tirage->oeuvre;
                    $isNew = $oeuvre->created_at >= now()->subDays(30);
                    $vendue = $tirage->vendue;
                    $prix = $tirage->prix;
                    $prixAffiche = $oeuvre->taux_reduction ? round($prix * (1 - $oeuvre->taux_reduction), 2) : $prix;
                @endphp
                <div class="break-inside-avoid mb-4">
                    <a href="{{ route('oeuvres.show', $oeuvre->id) }}"
                       class="block relative group overflow-hidden rounded-xl bg-gray-100">
                        <img src="https://images.unsplash.com/photo-1579783902614-a3fb3927b6a5?w=500"
                             alt="{{ $oeuvre->titre }}"
                             class="w-full h-auto object-contain transition-transform
                                    duration-500 group-hover:scale-105"
                             loading="lazy">
                        @if($isNew && !$vendue)
                            <span class="absolute top-2 left-2 bg-black text-white
                                         text-[10px] font-bold px-2 py-0.5 rounded tracking-wider">
                                NEW
                            </span>
                        @endif
                        @if($oeuvre->taux_reduction && !$vendue)
                            <span class="absolute top-2 right-2 bg-[#E8490F] text-white
                                         text-[10px] font-bold px-2 py-0.5 rounded">
                                -{{ $oeuvre->taux_reduction * 100 }}%
                            </span>
                        @endif
                        @if($vendue)
                            <div class="absolute inset-0 bg-black/60 flex items-center
                                        justify-center rounded-xl">
                                <span class="text-white font-black text-xl tracking-widest">
                                    Vendue
                                </span>
                            </div>
                        @endif
                    </a>
                    <div class="mt-2 px-1">
                        <p class="text-xs text-gray-500 truncate">
                            {{ $oeuvre->artiste->nom_d_artiste ?? $oeuvre->artiste->user->nom }}
                            @if($oeuvre->artiste->Est_Artiste_Art3f)
                                <span class="inline-block w-1.5 h-1.5 rounded-full bg-[#E8490F] ml-1"></span>
                            @endif
                        </p>
                        <p class="text-sm font-semibold text-[#1A1A1A] truncate mt-0.5">
                            {{ $oeuvre->titre }}
                        </p>
                        <p class="text-xs text-gray-400 mt-0.5">
                            {{ $oeuvre->categorie->nom_categorie }}
                            @if($tirage?->dimension)
                                · {{ $tirage->dimension->hauteur }}×{{ $tirage->dimension->largeur }} cm
                            @endif
                        </p>
                        @if(!$vendue && $tirage)
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-sm font-bold text-[#E8490F]">
                                    {{ number_format($prixAffiche, 0, ',', ' ') }} €
                                </span>
                                @if($oeuvre->taux_reduction)
                                    <span class="text-xs text-gray-400 line-through">
                                        {{ number_format($prix, 0, ',', ' ') }} €
                                    </span>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
        <div class="w-full bg-zinc-900 border border-zinc-700 rounded-xl overflow-hidden flex items-center">

            <!-- Partie gauche : photo -->
            <div class="relative w-32 h-20 bg-black flex flex-col items-center justify-center shrink-0">

                <!-- Badge -->
                <span
                    class="absolute top-1 left-1 bg-black/80 text-white text-[10px] px-2 py-0.5 rounded-md font-semibold">
                    artiste sponsorisé
                </span>

                <!-- Image -->
                <img
                    src="{{ asset('images/artiste.jpg') }}"
                    alt="Photo artiste"
                    class="w-full h-full object-cover"
                >

                {{-- Si tu n'as pas encore d'image --}}
                {{-- <span class="text-white text-sm font-bold text-center">Photo<br>artiste</span> --}}
            </div>

            <!-- Informations -->
            <div class="flex-1 px-6">
                <h2 class="text-white font-bold text-2xl uppercase">
                    {{ $artiste->nom ?? 'PAXAL VAN KAUFFMANN' }}
                </h2>

                <p class="text-gray-400 text-sm mt-1">
                    {{ $artiste->specialite ?? 'Peintre' }}
                    •
                    {{ $artiste->ville ?? 'Mulhouse' }},
                    {{ $artiste->pays ?? 'France' }}
                </p>
            </div>

            <!-- Bouton -->
            <div class="pr-6">
                <a href="#"
                   class="inline-flex items-center gap-2 bg-orange-600 hover:bg-orange-500 transition text-white font-semibold px-6 py-3 rounded-xl">
                    Découvrir

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="w-4 h-4"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
   
@endif

@include('layouts.partials.Footer')

    

