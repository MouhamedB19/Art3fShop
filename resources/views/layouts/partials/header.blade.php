{{--
    ┌─────────────────────────────────────────────────────────────┐
    │  HEADER — art3f Shop                                        │
    │  resources/views/layouts/partials/header.blade.php          │
    │                                                             │
    │  Utilisation dans app.blade.php :                           │
    │      @include('layouts.partials.header')                    │
    │                                                             │
    │  Requis dans app.blade.php (dans <head>) :                  │
    │      @vite(['resources/css/app.css','resources/js/app.js']) │
    └─────────────────────────────────────────────────────────────┘
--}}

{{-- ═══════════════════════════════════════════════════════════
     BARRE D'INFO (promotions, offres commerciales)
     Contenu géré via config ou variable $promo_message
     ═══════════════════════════════════════════════════════════ --}}

@if(isset($promo_message) || config('art3f.promo_message'))
    <div class="bg-[#1A1A1A] text-white text-xs text-center py-2 px-4">
        <a href="{{ config('art3f.promo_url', '#') }}"
           class="hover:text-[#F97316] transition-colors duration-200 flex items-center justify-center gap-2">
            <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                      d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12z"/>
            </svg>
            <span>{{ $promo_message ?? config('art3f.promo_message') }}</span>
        </a>
    </div>
@endif

{{-- ═══════════════════════════════════════════════════════════
     HEADER PRINCIPAL — sticky
     ═══════════════════════════════════════════════════════════ --}}
<header
    x-data="{ mobileOpen: false, megaMenu: null }"
    class="sticky top-0 z-50 bg-white shadow-md"
>

    {{-- ── BARRE HAUTE (identification + préférences + aide) ────── --}}
    <div class="border-b border-gray-100 hidden lg:block">
        <div class="max-w-screen-xl mx-auto px-4 h-9 flex items-center justify-between text-xs text-gray-600">

            {{-- Gauche : connexion --}}
            <div class="flex items-center gap-4">
                @auth
                    <span class="text-gray-500">Bonjour,
                        @if(Auth::user()->estArtiste() && Auth::user()->artiste->nom_d_artiste)
                            <span class="font-semibold text-[#1A1A1A]">{{Auth::user()->prenom}} {{ Auth::user()->artiste->nom_d_artiste }}</span>
                        @else
                            <span class="font-semibold text-[#1A1A1A]">{{ Auth::user()->prenom }}</span>
                        @endif
                    </span>
                    
                    @if(auth()->user()->estAdmin())
                        <x-lien-orange-art3f destination="{{ route('admin.dashboard') }}" label="Administration"/>
                    @else
                        <x-lien-orange-art3f destination="{{ route('compte.index') }}" label="Mon compte"/>

                        @if(auth()->user()->estArtiste())
                            <x-lien-orange-art3f destination="{{ route('artiste.compte') }}" label="Mon espace artiste"/>
                        @endif
                    @endif
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="hover:text-[#E8490F] transition-colors">
                            Se déconnecter
                        </button>
                    </form>
                @else
                    <x-lien-orange-art3f destination="{{ route('register') }}" label="S'inscrire"/>
                    <span class="text-gray-300">|</span>
                    <x-lien-orange-art3f destination="{{ route('login') }}" label="Se connecter"/>
                @endauth
            </div>
            
            
            {{-- Droite : icônes utilisateur + préférences + aide --}}
            <div class="flex items-center gap-4">
                @if(Auth::user() && !Auth::user()->estArtiste())
                    <div class="flex gap-4">

                        {{-- Œuvres coup de cœur --}}
                        <x-lien-icone-compteur
                            :destination="route('compte.favoris.oeuvres')"                  
                            title="Mes œuvres coup de cœur"                 
                            :count="Auth::user()->estClient() ? Auth::user()->nombreOeuvresFavoris() : null">
                            <svg class="w-4 h-4 group-hover:fill-[#E8490F] transition-all" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312
                                         2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0
                                         7.22 9 12 9 12s9-4.78 9-12z"/>
                            </svg>
                        </x-lien-icone-compteur> 

                        {{-- Favoris Artistes --}}
                        <x-lien-icone-compteur
                            :destination="route('compte.favoris.artistes')"                  
                            title="Mes artistes coup de cœur"                 
                            :count="Auth::user()?->estClient() ? Auth::user()?->nombreArtistesFavoris() : null">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5
                                         7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676
                                         0-5.216-.584-7.499-1.632z"/>
                            </svg>
                        </x-lien-icone-compteur>                      

                        {{-- Panier --}}
                        <x-lien-icone-compteur
                            :destination="route('panier.index')"                  
                            title="Mon panier"                 
                            :count="Auth::user()?->estClient() ? Auth::user()->client->tirages()->count() : null">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993
                                       1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0
                                       01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576
                                       0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375
                                       0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"
                                />
                            </svg>

                        </x-lien-icone-compteur>
                    </div>
                @endif
                    
                    
                    {{-- Séparateur --}}
                    <span class="text-gray-200 select-none">|</span>
               

                {{-- Langue --}}
                <div class="flex gap-4">
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                                class="flex items-center gap-1 hover:text-[#E8490F] transition-colors font-medium uppercase">
                            {{ app()->getLocale() }}
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open" @click.outside="open = false"
                             x-transition
                             class="absolute right-0 top-full mt-1 bg-white border border-gray-200
                                    rounded shadow-lg z-50 overflow-hidden">
                            @foreach(['fr' => 'Français', 'en' => 'English'] as $locale => $label)
                                <a href="{{ route('locale.switch', $locale) }}"
                                   class="block px-4 py-2 text-xs hover:bg-gray-50 hover:text-[#E8490F]
                                          {{ app()->getLocale() === $locale ? 'font-bold text-[#E8490F]' : '' }}">
                                    {{ $label }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    {{-- Devise --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                                class="flex items-center gap-1 hover:text-[#E8490F] transition-colors font-medium">
                            € {{ session('devise', 'EUR') }}
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="open" @click.outside="open = false"
                             x-transition
                             class="absolute right-0 top-full mt-1 bg-white border border-gray-200
                                    rounded shadow-lg z-50 overflow-hidden">
                            @foreach(['EUR' => '€ EUR', 'GBP' => '£ GBP', 'USD' => '$ USD', 'CHF' => 'CHF'] as $code => $label)
                                <a href="{{ route('devise.switch', $code) }}"
                                   class="block px-4 py-2 text-xs hover:bg-gray-50 hover:text-[#E8490F]
                                          {{ session('devise', 'EUR') === $code ? 'font-bold text-[#E8490F]' : '' }}">
                                    {{ $label }}
                                </a>
                            @endforeach
                        </div>
                    </div>

                    {{-- Aide / FAQ --}}
                    <a href="{{ route('faq.index') }}"
                       class="hover:text-[#E8490F] transition-colors"
                       title="Aide">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172
                                     2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45
                                     1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- ── BARRE PRINCIPALE (logo + recherche + menu) ────────────── --}}
    <div class="max-w-screen-xl mx-auto px-4">
        <div class="flex items-center gap-6 h-16">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="shrink-0">
                <img src="{{ asset('images/logo-art3f-shop.png') }}"
                     alt="art3f Shop"
                     class="h-12 w-auto">
                {{-- Fallback texte si pas encore d'image --}}
                {{-- <span class="font-black text-2xl tracking-tight">art<span class="text-[#E8490F]">3f</span>
                    <span class="font-light text-sm ml-1">SHOP</span></span> --}}
            </a>

            {{-- Barre de recherche --}}
            <div x-data="{ 
                query: '', 
                resultats: { oeuvres: [], artistes: [], categories: [] }, 
                ouvert: false 
            }"
            class="relative w-full max-w-md hidden lg:block"
            @click.outside="ouvert = false"
            >
                <input
                    type="text"
                    x-model="query"
                    @input.debounce.300ms="if(query.length >= 2) {
                        ouvert = true;
                        fetch(`/api/recherche?q=${query}`)
                            .then(r => r.json())
                            .then(d => resultats = d)
                    } else { ouvert = false }"
                    @keydown.enter="window.location.href = `/recherche?q=${query}`"
                    placeholder="Artiste, œuvre, mot clé..."
                    class="w-full border rounded-2xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#E8490F]"
                >

                <div
                x-show="ouvert"
                x-transition
                class="absolute z-50 w-full bg-white shadow-lg rounded-2xl mt-2 p-4 max-h-96 overflow-y-auto"
                >
                    <template x-if="resultats.oeuvres.length">
                        <div class="mb-4">
                            <p class="text-xs uppercase text-gray-400 font-semibold mb-2">Œuvres</p>
                            <template x-for="o in resultats.oeuvres" :key="o.id">
                                <a :href="`/oeuvres/${o.id}`"
                                   class="flex items-center gap-3 px-4 py-2.5 hover:bg-orange-50 transition-colors">
                                    <img :src="o.photo_thumb" class="w-10 h-10 object-cover rounded">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900" x-html="o.titre_highlighted"></p>
                                        <p class="text-xs text-gray-500" x-text="o.artiste"></p>
                                    </div>
                                    <span class="ml-auto text-sm font-bold"
                                          :class="o.vendu ? 'text-gray-400' : 'text-[#E8490F]'"
                                          x-text="o.vendu ? 'Vendu' : (o.prix + ' €')"></span>
                                </a>
                            </template>
                        </div>
                    </template>

                    <template x-if="resultats.artistes.length">
                        <div class="mb-4">
                            <p class="text-xs uppercase text-gray-400 font-semibold mb-2">Artistes</p>
                            <template x-for="a in resultats.artistes" :key="a.id">
                                <a :href="`/artistes/${a.id}`"
                                   class="flex items-center gap-3 px-4 py-2.5 hover:bg-orange-50 transition-colors">
                                    <img :src="a.photo" class="w-8 h-8 object-cover rounded-full">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900" x-html="a.nom_highlighted"></p>
                                        <p class="text-xs text-gray-500" x-text="a.ville + ' · ' + a.pays"></p>
                                    </div>
                                </a>
                            </template>
                        </div>
                    </template>
                
                    <template x-if="resultats.categories.length">
                        <div>
                            <p class="text-xs uppercase text-gray-400 font-semibold mb-2">Catégories</p>
                            <template x-for="c in resultats.categories" :key="c.id">
                                <a :href="`/catalogue/${c.label}`"
                                   class="flex items-center gap-2 px-4 py-2 hover:bg-orange-50 transition-colors">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-5 5a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 10V5a2 2 0 012-2z"/>
                                    </svg>
                                    <span class="text-sm text-gray-700" x-text="c.label"></span>
                                </a>
                            </template>
                        </div>
                    </template>
                
                    <template x-if="resultats.oeuvres.length === 0 && resultats.artistes.length === 0 && resultats.categories.length === 0">
                        <p class="text-gray-400 text-sm">Aucun résultat</p>
                    </template>
                </div>        
                
                
            </div>
            {{-- Burger mobile --}}
            <button @click="mobileOpen = !mobileOpen"
                class="lg:hidden ml-auto p-2 w-6 h-6 rounded-lg hover:bg-gray-100 transition-colors relative"
                aria-label="Menu">
                <svg x-show="!mobileOpen" class="absolute top-0 left-0 w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg x-show="mobileOpen" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            

        </div>
        
        
    </div>
    
    {{-- ── MENU DE NAVIGATION (desktop) ─────────────────────────── --}}
    <nav class="hidden lg:block border-t border-gray-100">
        <div class="max-w-screen-xl mx-auto px-4">
            <ul class="flex items-center gap-1 h-11 text-sm font-semibold uppercase tracking-wide list-none p-0 m-0">

                {{-- LES ŒUVRES (avec mega-menu) --}}
                <li class="relative group"
                    @mouseenter="megaMenu = 'oeuvres'"
                    @mouseleave="megaMenu = null">
                    <a href="{{ route('catalogue.index') }}"
                       class="flex items-center gap-1 px-3 h-11 hover:text-[#E8490F] transition-colors
                              {{ request()->routeIs('catalogue.*') ? 'text-[#E8490F] border-b-2 border-[#E8490F]' : '' }}">
                        Les œuvres
                        <svg class="w-3 h-3 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </a>

                    {{-- Mega-menu Œuvres --}}
                    <div x-show="megaMenu === 'oeuvres'"
                         x-transition:enter="transition ease-out duration-150"
                         x-transition:enter-start="opacity-0 -translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         class="absolute left-0 top-full w-[640px] bg-white border border-gray-200
                                shadow-xl rounded-b-xl z-50 p-6">
                        <div class="grid grid-cols-3 gap-6">

                            {{-- Catégories --}}
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">
                                    Toutes les œuvres
                                </p>
                                <ul class="space-y-1 list-none p-0 m-0">
                                    @foreach([
                                            ["peinture", 'Peinture'],
                                            ["sculpture", 'Sculpture'],
                                            ["photographie", 'Photographie'],
                                            ["edition", 'Édition'],
                                            ["dessin", 'Dessin'],
                                        ] as [$slug, $label])
                                                    <li>
                                                        <x-lien-dropdown 
                                                            destination="{{ route('catalogue.categorie', $slug) }}"
                                                            label="{{$label}}"
                                                        />
                                                    </li>
                                    @endforeach
                                </ul>
                                <a href="{{ route('catalogue.index') }}"
                                   class="inline-flex items-center gap-1 mt-3 text-xs font-bold
                                          text-[#E8490F] hover:underline">
                                    Voir tout →
                                </a>
                            </div>

                            {{-- Thèmes --}}
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">
                                    Thèmes populaires
                                </p>
                                <ul class="space-y-1 list-none p-0 m-0">
                                    @foreach($themes as $theme)
                                        <li>
                                            <x-lien-dropdown 
                                            destination="{{ route('catalogue.theme', Str::slug($theme)) }}"
                                            label="{{ $theme }}"
                                            />
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            {{-- Sélections --}}
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">
                                    Nos sélections
                                </p>
                                <div class="space-y-2">
                                    <a href="{{ route('selections.index') }}"
                                       class="block rounded-lg overflow-hidden group/sel">
                                        <div class="bg-[#1A1A1A] text-white text-xs font-bold p-3
                                                    group-hover/sel:bg-[#E8490F] transition-colors">
                                            🎨 Nouveautés
                                        </div>
                                    </a>
                                    <a href="{{ route('selections.show', 'coups-de-coeur') }}"
                                       class="block rounded-lg overflow-hidden group/sel">
                                        <div class="bg-gray-100 text-gray-700 text-xs font-bold p-3
                                                    group-hover/sel:bg-[#E8490F] group-hover/sel:text-white transition-colors">
                                            ❤️ Coups de cœur
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                {{-- Catégories directes --}}
                @foreach([
                        ['peinture', 'Peinture'],
                        ['sculpture', 'Sculpture'],
                        ['photographie', 'Photographie'],
                        ['edition', 'Édition'],
                        ['dessin', 'Dessin'],
                    ] as [$slug, $label])
                                <li>
                                    <a href="{{ route('catalogue.categorie', $slug) }}"
                                       class="px-3 h-11 flex items-center hover:text-[#E8490F] transition-colors
                                              {{ request()->is("catalogue/{$slug}*") ? 'text-[#E8490F] border-b-2 border-[#E8490F]' : '' }}">
                                        {{ $label }}
                                    </a>
                                </li>
                @endforeach

                {{-- LES ARTISTES --}}
                <li class="ml-auto">
                    <a href="{{ route('artistes.index') }}"
                       class="px-4 h-11 flex items-center font-extrabold tracking-wider
                              hover:text-[#E8490F] transition-colors
                              {{ request()->routeIs('artistes.*') ? 'text-[#E8490F]' : '' }}">
                        Les artistes
                    </a>
                </li>

            </ul>
        </div>
    </nav>

    {{-- ── MENU MOBILE ────────────────────────────────────────────── --}}
    <div x-show="mobileOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="lg:hidden border-t border-gray-100 bg-white">
        <div class="max-w-screen-xl mx-auto px-4 py-4 space-y-1">
            {{--Où est le bouton ?--}}
            {{-- Recherche mobile (simple, sans live-search) --}}
            <form action="{{ route('recherche.index') }}" method="GET" class="mb-3">
                <input
                    type="text"
                    name="q"
                    placeholder="Artiste, œuvre, mot clé..."
                    class="w-full border rounded-2xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#E8490F]"
                >
            </form>

            <a href="{{ route('catalogue.index') }}"
               class="block px-3 py-2.5 text-sm font-semibold rounded-lg hover:bg-orange-50 hover:text-[#E8490F] transition-colors">
                Les œuvres
            </a>

            @foreach([
                    ['peinture', 'Peinture'],
                    ['sculpture', 'Sculpture'],
                    ['photographie', 'Photographie'],
                    ['edition', 'Édition'],
                    ['dessin', 'Dessin'],
                ] as [$slug, $label])
                            <a href="{{ route('catalogue.categorie', $slug) }}"
                               class="block px-6 py-2 text-sm text-gray-600 hover:text-[#E8490F] transition-colors">
                                → {{ $label }}
                            </a>
            @endforeach

            <a href="{{ route('artistes.index') }}"
               class="block px-3 py-2.5 text-sm font-extrabold rounded-lg hover:bg-orange-50 hover:text-[#E8490F] transition-colors">
                Les artistes
            </a>

            <div class="border-t border-gray-100 pt-3 mt-3 space-y-1">
                @auth
                    <a href="{{ route('compte.index') }}"
                       class="block px-3 py-2 text-sm text-gray-600 hover:text-[#E8490F]">Mon compte</a>
                       @if(auth()->user()->estArtiste())
                        <a href="{{ route('artiste.compte') }}">Mon espace artiste</a>
                       @endif
                @else
                    <a href="{{ route('register') }}"
                       class="block px-3 py-2 text-sm font-semibold text-[#E8490F]">S'inscrire</a>
                    <a href="{{ route('login') }}"
                       class="block px-3 py-2 text-sm text-gray-600 hover:text-[#E8490F]">Se connecter</a>
                @endauth
            </div>
        </div>
    </div>

</header>

{{--
    ─────────────────────────────────────────────────────────────
    ROUTES nécessaires (web.php) :
    ─────────────────────────────────────────────────────────────
    Route::get('/', ...)->name('home');
    Route::get('/catalogue', ...)->name('catalogue.index');
    Route::get('/catalogue/{categorie}', ...)->name('catalogue.categorie');
    Route::get('/catalogue/theme/{theme}', ...)->name('catalogue.theme');
    Route::get('/artistes', ...)->name('artistes.index');
    Route::get('/recherche', ...)->name('recherche.index');
    Route::get('/api/recherche', ...)->name('api.recherche');
    Route::get('/panier', ...)->name('panier.index');
    Route::get('/compte', ...)->name('compte.index');
    Route::get('/compte/favoris/oeuvres', ...)->name('compte.favoris.oeuvres');
    Route::get('/compte/favoris/artistes', ...)->name('compte.favoris.artistes');
    Route::get('/faq', ...)->name('faq.index');
    Route::get('/locale/{locale}', ...)->name('locale.switch');
    Route::get('/devise/{devise}', ...)->name('devise.switch');
    Route::get('/selections', ...)->name('selections.index');
    Route::get('/selections/{slug}', ...)->name('selections.show');
    ─────────────────────────────────────────────────────────────
    DÉPENDANCES :
    - Alpine.js (x-data, x-show, x-model...)  → dans app.js via npm
    - Tailwind CSS                              → dans app.css via npm
    - @vite(['resources/css/app.css','resources/js/app.js']) dans <head>
    ─────────────────────────────────────────────────────────────
--}}