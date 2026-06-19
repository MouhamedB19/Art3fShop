@extends('layouts.app')

@section('title', $tirage->oeuvre->titre . ' — ' . ($tirage->oeuvre->artiste->nom_d_artiste ?? $tirage->oeuvre->artiste->user->nom))
@section('meta_description', Str::limit($tirage->oeuvre->description, 160))

@section('breadcrumb')
    <a href="{{ route('home') }}" class="hover:text-[#E8490F] transition-colors">Accueil</a>
    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
    </svg>
    <a href="{{ route('catalogue.index') }}" class="hover:text-[#E8490F] transition-colors">Catalogue</a>
    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
    </svg>
    <a href="{{ route('catalogue.categorie', $tirage->oeuvre->categorie->nom_categorie) }}"
       class="hover:text-[#E8490F] transition-colors">
        {{ $tirage->oeuvre->categorie->nom_categorie }}
    </a>
    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
    </svg>
    <span class="text-[#1A1A1A] font-medium truncate max-w-[200px]">{{ $tirage->oeuvre->titre }}</span>
@endsection

@section('content')

    @php

        $vendue      = $tirage?->status === 'vendu';
        $prix        = $tirage?->prix ?? 0;
        $prixAffiche = $tirage->oeuvre->taux_reduction
            ? round($prix * (1 - $tirage->oeuvre->taux_reduction), 2)
            : $prix;
        $nomArtiste  = $tirage->oeuvre->artiste->nom_d_artiste ?? $tirage->oeuvre->artiste->user->nom;
    @endphp

    <div class="max-w-screen-xl mx-auto px-4 py-8"
         x-data="{
             photoActive: '{{ asset('storage/' . $tirage->oeuvre->photo_principale) }}',
             dedicace: false,
             cadeau: false,
         }">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

            {{-- ═══════════════════════════════════════
                 COLONNE GAUCHE — Galerie photos
                 ═══════════════════════════════════════ --}}
            <div>

                {{-- Photo principale --}}
                <div class="relative overflow-hidden rounded-2xl bg-gray-50 border border-gray-100">
                    <img src="https://images.unsplash.com/photo-1579783902614-a3fb3927b6a5?w=500"
                         alt="{{ $tirage->oeuvre->titre }}"
                         class="w-full h-auto object-contain max-h-[600px]">

                    {{-- Badge VENDUE --}}
                    @if($vendue)
                        <div class="absolute inset-0 bg-black/60 flex items-center justify-center rounded-2xl">
                            <span class="text-white font-black text-3xl tracking-widest uppercase">Vendue</span>
                        </div>
                    @endif

                    {{-- Badge promo --}}
                    @if($tirage->oeuvre->taux_reduction && !$vendue)
                        <span class="absolute top-3 left-3 bg-[#E8490F] text-white
                                     text-xs font-bold px-3 py-1 rounded-full">
                            -{{ $tirage->oeuvre->taux_reduction * 100 }}%
                        </span>
                    @endif
                </div>

                
                {{-- Pour le proto : on affiche seulement la photo principale --}}
                {{-- En V2 : ajouter photos_secondaires à la table oeuvres --}}
                <div class="flex items-center gap-2 mt-3">
                       
                    {{-- Boutons mock-up et AR --}}
                    <div class="flex gap-2 ml-2">
                        <button class="flex flex-col items-center gap-1 px-4 py-2 border border-gray-200
                                       rounded-lg text-xs text-gray-500 hover:border-[#E8490F]
                                       hover:text-[#E8490F] transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                            </svg>
                            Projetez
                        </button>
                        <button class="flex flex-col items-center gap-1 px-4 py-2 border border-gray-200
                                       rounded-lg text-xs text-gray-500 hover:border-[#E8490F]
                                       hover:text-[#E8490F] transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                      d="M15 10l4.553-2.069A1 1 0 0121 8.87v6.26a1 1 0 01-1.447.894L15 14M3
                                         8h12v8H3z"/>
                            </svg>
                            Imaginez
                        </button>
                    </div>
                </div>

            </div>

            {{-- ═══════════════════════════════════════
                 COLONNE DROITE — Infos & achat
                 ═══════════════════════════════════════ --}}
            <div class="space-y-6">

                {{-- Prix + coup de cœur --}}
                <div class="flex items-start justify-between">
                    <div>
                        @if(!$vendue)
                            <div class="flex items-baseline gap-3">
                                <span id="prix-text" class="text-3xl font-black text-[#E8490F]">
                                    @if($tirage->oeuvre->avec_cadre === 1)
                                        {{ number_format($prixAffiche, 0, ',', ' ') }} €
                                    @else
                                        {{ number_format($prixAffiche - 150,0,',',' ') }} €
                                    @endif
                                </span>
                                @if($tirage->oeuvre->taux_reduction)
                                    <span class="text-lg text-gray-400 line-through">
                                        {{ number_format($prix, 0, ',', ' ') }} €
                                    </span>
                                @endif
                            </div>
                            <p class="text-xs text-gray-400 mt-1">Frais de livraison offerts (Union Européenne)</p>
                        @else
                            <span class="text-xl font-bold text-gray-400">Œuvre vendue</span>
                        @endif
                    </div>
                    {{-- Coup de cœur --}}
                    @auth
                        <button class="w-10 h-10 rounded-full border border-gray-200 flex items-center
                                       justify-center hover:border-red-400 hover:bg-red-50 transition-colors group">
                            <svg class="w-5 h-5 text-gray-400 group-hover:text-red-500 transition-colors"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312
                                         2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0
                                         7.22 9 12 9 12s9-4.78 9-12z"/>
                            </svg>
                        </button>
                    @endauth
                </div>

                {{-- Bouton ajouter au panier --}}
                @if(!$vendue)
                    <form action="{{ route('panier.ajout',$tirage) }}" method="POST">
                        @csrf
                        <input type="hidden" name="tirage_id" value="{{ $tirage->id }}">
                        <input type="hidden" name="avec_cadre" x-bind:value="avecCadre ?? 0">
                        <button type="submit"
                                class="w-full bg-[#1A1A1A] hover:bg-[#E8490F] text-white font-bold
                                       py-4 rounded-xl transition-colors duration-200 text-sm tracking-wide
                                       uppercase">
                            Ajouter au panier
                        </button>
                    </form>
                @endif

                {{-- Partage réseaux sociaux --}}
                <div class="flex items-center gap-3">
                    <span class="text-xs text-gray-400">Partager :</span>
                    @foreach([
                        ['linkedin', 'M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z M4 6a2 2 0 100-4 2 2 0 000 4z'],
                        ['facebook', 'M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z'],
                        ['instagram',''],
                    ] as [$name, $path])
                        <a href="#" class="text-gray-400 hover:text-[#E8490F] transition-colors"
                           aria-label="{{ $name }}">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="{{ $path }}"/>
                            </svg>
                        </a>
                    @endforeach
                </div>

                {{-- Liens contact --}}
                <div class="flex items-center gap-4 text-sm">
                    <a href="{{ route('contact') }}?sujet=oeuvre&id={{ $tirage->oeuvre->id }}"
                       class="text-[#E8490F] hover:underline flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278
                                     2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0
                                     11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Poser une question
                    </a>
                    <a href="{{ route('contact') }}?sujet=offre&id={{ $tirage->oeuvre->id }}"
                       class="text-[#E8490F] hover:underline flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3
                                     2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11
                                     0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Faire une offre
                    </a>
                </div>

                {{-- Artiste --}}
                <div class="flex items-center gap-3 py-4 border-y border-gray-100">
                    <a href="{{ route('artistes.show', $tirage->oeuvre->artiste->id) }}">
                        @if($tirage->oeuvre->artiste->photo)
                            <img src="https://thispersondoesnotexist.com/"
                                 alt="{{ $nomArtiste }}"
                                 class="w-12 h-12 rounded-full object-cover">
                        @else
                            <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center
                                        justify-center text-gray-400 font-bold text-lg">
                                {{ strtoupper(substr($nomArtiste, 0, 1)) }}
                            </div>
                        @endif
                    </a>
                    <div>
                        <a href="{{ route('artistes.show', $tirage->oeuvre->artiste->id) }}"
                           class="font-bold text-[#1A1A1A] hover:text-[#E8490F] transition-colors">
                            {{ $nomArtiste }}
                            @if($tirage->oeuvre->artiste->Est_Artiste_Art3f)
                                <span class="inline-block w-2 h-2 rounded-full bg-[#E8490F] ml-1"></span>
                            @endif
                        </a>
                        @if($tirage->oeuvre->artiste->localisation?->ville)
                            <p class="text-xs text-gray-400">
                                {{ $tirage->oeuvre->artiste->localisation->ville->nom_ville }},
                                {{ $tirage->oeuvre->artiste->localisation->ville->pays->nom_pays }}
                            </p>
                        @endif
                    </div>
                </div>

                {{-- Titre + année --}}
                <div>
                    <h1 class="text-2xl font-black text-[#1A1A1A]">{{ $tirage->oeuvre->titre }}</h1>
                    <p class="text-sm text-gray-400 mt-1">{{ $tirage->oeuvre->annee_de_creation }}</p>
                </div>

                {{-- Infos pratiques --}}
                <div class="bg-gray-50 rounded-xl p-5 space-y-3">
                    <h2 class="text-xs font-bold text-gray-400 uppercase tracking-widest">
                        Infos pratiques
                    </h2>
                    @foreach([
                        ['Technique',   $tirage->oeuvre->categorie->nom_technique ?? $tirage->oeuvre->categorie->nom_categorie],
                        ['Support',     $tirage->oeuvre->support->nom_support],
                        ['Dimensions',  $tirage?->dimension()
                            ? $tirage->dimension->hauteur . ' × ' . $tirage->dimension->largeur . ' cm'
                            : '—'],
                        ['Tirage',      $tirage ? 'N°' . $tirage->numero : '—'],
                        ['Accrochage',  $tirage?->pret_a_accrocher ? 'Prêt à accrocher' : 'Non'],
                    ] as [$label, $value])
                        <div class="flex items-start justify-between gap-4">
                            <span class="text-sm text-gray-500 shrink-0">{{ $label }}</span>
                            <span class="text-sm font-medium text-[#1A1A1A] text-right">{{ $value }}</span>
                        </div>
                    @endforeach
                    <div class="flex gap-2 flex-wrap">
                        @foreach($tousLesTirages as $t)
                            <a href="{{ route('oeuvres.show.tirage', [$oeuvre, $t]) }}"
                               class="px-3 py-2 rounded-lg border text-sm
                                      {{ $t->id === $tirage->id ? 'border-[#E8490F] text-[#E8490F]' : 'border-gray-200 text-gray-600' }}
                                      {{ $t->status === 'vendu' ? 'opacity-40 line-through' : '' }}">
                                N°{{ $t->numero }} — {{ $t->dimension->largeur }}×{{ $t->dimension->hauteur }}cm
                            </a>
                        @endforeach
                    </div>
                    {{-- Certificat --}}
                    <div class="flex items-center gap-2 pt-2 border-t border-gray-200">
                        <svg class="w-4 h-4 text-green-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-xs text-gray-500">Œuvre originale avec certificat d'authenticité</span>
                    </div>

                    {{-- Option encadrement --}}
                    @if($tirage?->encadrement)
                        <div class="pt-2 border-t border-gray-200"
                             x-data="{ avecCadre: true }">
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox"
                                       x-model="avecCadre" id="avec-cadre"
                                       class="rounded border-gray-300 text-[#E8490F] focus:ring-[#E8490F]">
                                <span class="text-sm text-gray-600">
                                    Acheter sans cadre
                                    <span class="text-[#E8490F] font-semibold">(-150 €)</span>
                                </span>
                            </label>
                        </div>
                    @endif
                </div>

                {{-- Option dédicace --}}
                <div x-data="{ dedicace: false }">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" x-model="dedicace"
                               class="rounded border-gray-300 text-[#E8490F] focus:ring-[#E8490F]">
                        <span class="text-sm text-gray-700">Demander une dédicace à l'artiste</span>
                    </label>
                    <div x-show="dedicace" x-transition class="mt-3">
                        <input type="text"
                               name="dedicace_destinataire"
                               placeholder="Destinataire de la dédicace"
                               class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg
                                      focus:outline-none focus:ring-2 focus:ring-[#E8490F]">
                    </div>
                </div>

                {{-- Option cadeau --}}
                <div x-data="{ cadeau: false }">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" x-model="cadeau"
                               class="rounded border-gray-300 text-[#E8490F] focus:ring-[#E8490F]">
                        <span class="text-sm text-gray-700">
                            🎁 C'est un cadeau ! Je fais livrer avec un message personnalisé.
                        </span>
                    </label>
                    <div x-show="cadeau" x-transition class="mt-3">
                        <textarea name="message_cadeau"
                                  placeholder="Votre message personnalisé…"
                                  rows="3"
                                  class="w-full px-4 py-2.5 text-sm border border-gray-300 rounded-lg
                                         focus:outline-none focus:ring-2 focus:ring-[#E8490F] resize-none">
                        </textarea>
                    </div>
                </div>

            </div>
        </div>

        {{-- ═══════════════════════════════════════
             À PROPOS DE CETTE ŒUVRE
             ═══════════════════════════════════════ --}}
        <div class="mt-16 max-w-3xl" x-data="{ expanded: false }">
            <h2 class="text-lg font-black text-[#1A1A1A] uppercase tracking-wide mb-4">
                À propos de cette œuvre
            </h2>
            <div class="text-gray-600 leading-relaxed text-sm"
                 :class="expanded ? '' : 'line-clamp-4'">
                {{ $tirage->oeuvre->description }}
            </div>
            <button @click="expanded = !expanded"
                    class="mt-3 text-sm text-[#E8490F] hover:underline font-medium">
                <span x-text="expanded ? 'Lire moins ↑' : 'Lire la suite →'"></span>
            </button>
        </div>

        {{-- ═══════════════════════════════════════
             BANDEAU ARTISTE
             ═══════════════════════════════════════ --}}
        <div class="mt-16 bg-[#1A1A1A] rounded-2xl overflow-hidden">
            <div class="flex flex-col md:flex-row">

                {{-- Photo artiste --}}
                <div class="md:w-64 shrink-0">
                    @if($tirage->oeuvre->artiste->photo)
                        <img src="https://thispersondoesnotexist.com/"
                             alt="{{ $nomArtiste }}"
                             class="w-full h-48 md:h-full object-cover">
                    @else
                        <div class="w-full h-48 md:h-full bg-gray-800 flex items-center
                                    justify-center text-gray-500 text-5xl font-black">
                            {{ strtoupper(substr($nomArtiste, 0, 1)) }}
                        </div>
                    @endif
                </div>

                {{-- Infos artiste --}}
                <div class="flex-1 p-8 text-white">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h3 class="text-2xl font-black uppercase tracking-wide">
                                {{ $nomArtiste }}
                            </h3>
                            <p class="text-gray-400 text-sm mt-1">
                                {{ $tirage->oeuvre->categorie->nom_categorie }}
                                @if($tirage->oeuvre->artiste->localisation?->ville)
                                    · {{ $tirage->oeuvre->artiste->localisation->ville->nom_ville }},
                                      {{ $tirage->oeuvre->artiste->localisation->ville->pays->nom_pays }}
                                @endif
                            </p>
                            @if($tirage->oeuvre->artiste->Est_Artiste_Art3f)
                                <span class="inline-flex items-center gap-1 mt-2 text-xs
                                             text-[#E8490F] font-semibold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-[#E8490F]"></span>
                                    Artiste art3f
                                </span>
                            @endif
                        </div>
                        <div class="flex flex-col gap-2 shrink-0">
                            <a href="{{ route('artistes.show', $tirage->oeuvre->artiste->id) }}"
                               class="px-4 py-2 bg-[#E8490F] hover:bg-orange-600 text-white text-xs
                                      font-bold rounded-lg transition-colors text-center">
                                Découvrir sa page
                            </a>
                            @auth
                                <button class="px-4 py-2 border border-white/20 hover:border-white
                                               text-white text-xs font-bold rounded-lg transition-colors">
                                    + Suivre cet artiste
                                </button>
                            @endauth
                        </div>
                    </div>

                    {{-- Bio courte --}}
                    @if($tirage->oeuvre->artiste->bio)
                        <p class="text-gray-300 text-sm mt-4 leading-relaxed line-clamp-3">
                            {{ $tirage->oeuvre->artiste->bio }}
                        </p>
                    @endif
                </div>
            </div>

            {{-- Œuvres du même artiste --}}
            @if($autresOeuvres->count() > 0)
                <div class="border-t border-white/10 p-6">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">
                        Œuvres du même artiste
                    </p>
                    <div class="flex gap-3 overflow-x-auto pb-2">
                        @foreach($autresOeuvres as $autre)
                            @php
                                $autreTirage = $autre->tirages->first();
                                $autreVendue = $autreTirage?->status === 'vendu';
                            @endphp
                            <a href="{{ route('oeuvres.show', $autre->id) }}"
                               class="shrink-0 w-36 group">
                                <div class="relative rounded-xl overflow-hidden bg-gray-800">
                                    <img src="https://images.unsplash.com/photo-1579783902614-a3fb3927b6a5?w=500"
                                         alt="{{ $autre->titre }}"
                                         class="w-36 h-36 object-contain transition-transform
                                                duration-300 group-hover:scale-105">
                                    @if($autreVendue)
                                        <div class="absolute inset-0 bg-black/60 flex items-center
                                                    justify-center">
                                            <span class="text-white text-xs font-bold uppercase">Vendue</span>
                                        </div>
                                    @endif
                                </div>
                                <p class="text-white text-xs font-medium mt-2 truncate">{{ $autre->titre }}</p>
                                @if($autreTirage && !$autreVendue)
                                    <p class="text-[#E8490F] text-xs font-bold">
                                        {{ number_format($autreTirage->prix, 0, ',', ' ') }} €
                                    </p>
                                @endif
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

    </div>
    
@endsection

