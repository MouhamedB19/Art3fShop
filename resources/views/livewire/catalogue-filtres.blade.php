<div>
    {{-- ═══════════════════════════════════════════════════
         BARRE DE FILTRES — sticky sous le header
         ═══════════════════════════════════════════════════ --}}
    <nav class="max-w-screen-xl mx-auto px-4 py-3 flex items-center gap-2 text-xs text-gray-500">
        <a href="{{ route('home') }}" class="hover:text-[#E8490F] transition-colors">Accueil</a>
        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <a href="{{ route('catalogue.index') }}" class="hover:text-[#E8490F] transition-colors">
            Toutes les œuvres
        </a>
        @if($categorieActive)
            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span class="text-[#1A1A1A] font-medium">{{ $categorieActive->nom_categorie }}</span>
        @endif
    </nav>
    <div class="bg-white border-b border-gray-200 sticky top-[4rem] z-40">
        <div class="max-w-screen-xl mx-auto px-4 py-3">

            <div class="flex flex-wrap items-center gap-3">

                {{-- ── Catégorie ── --}}
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                            class="flex items-center gap-1.5 px-3 py-1.5 text-sm border rounded-lg
                                   hover:border-[#E8490F] transition-colors
                                   {{ $categorie_id ? 'border-[#E8490F] bg-orange-50 text-[#E8490F] font-semibold' : 'border-gray-300 text-gray-700' }}">
                        Catégorie
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" @click.outside="open = false" x-transition
                         class="absolute top-full left-0 mt-1 bg-white border border-gray-200
                                rounded-xl shadow-xl z-50 p-2 min-w-[200px]">
                        <button wire:click="$set('categorie_id', null)" @click="open = false"
                                class="block w-full text-left px-3 py-2 text-sm rounded-lg
                                       hover:bg-orange-50 hover:text-[#E8490F] transition-colors
                                       {{ !$categorie_id ? 'font-bold text-[#E8490F]' : '' }}">
                            Toutes
                        </button>
                        @foreach($categories as $cat)
                            <button wire:click="$set('categorie_id', {{ $cat->id }})" @click="open = false"
                                    class="block w-full text-left px-3 py-2 text-sm rounded-lg
                                           hover:bg-orange-50 hover:text-[#E8490F] transition-colors
                                           {{ $categorie_id == $cat->id ? 'font-bold text-[#E8490F]' : '' }}">
                                {{ $cat->nom_categorie }}
                            </button>
                        @endforeach
                    </div>
                </div>

                {{-- ── Thèmes ── --}}
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                            class="flex items-center gap-1.5 px-3 py-1.5 text-sm border rounded-lg
                                   hover:border-[#E8490F] transition-colors
                                   {{ !empty($theme_ids) ? 'border-[#E8490F] bg-orange-50 text-[#E8490F] font-semibold' : 'border-gray-300 text-gray-700' }}">
                        Thèmes
                        @if(!empty($theme_ids))
                            <span class="bg-[#E8490F] text-white text-[10px] font-bold
                                         rounded-full w-4 h-4 flex items-center justify-center">
                                {{ count($theme_ids) }}
                            </span>
                        @endif
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" @click.outside="open = false" x-transition
                         class="absolute top-full left-0 mt-1 bg-white border border-gray-200
                                rounded-xl shadow-xl z-50 p-2 min-w-[200px] max-h-64 overflow-y-auto">
                        @foreach($themes as $theme)
                            <label class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg
                                          hover:bg-orange-50 cursor-pointer transition-colors">
                                <input type="checkbox"
                                       wire:model.live="theme_ids"
                                       value="{{ $theme->id }}"
                                       class="rounded border-gray-300 text-[#E8490F] focus:ring-[#E8490F]">
                                {{ $theme->nom_theme }}
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- ── Couleurs ── --}}
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                            class="flex items-center gap-1.5 px-3 py-1.5 text-sm border rounded-lg
                                   hover:border-[#E8490F] transition-colors
                                   {{ !empty($couleur_ids) ? 'border-[#E8490F] bg-orange-50 text-[#E8490F] font-semibold' : 'border-gray-300 text-gray-700' }}">
                        Couleur
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" @click.outside="open = false" x-transition
                         class="absolute top-full left-0 mt-1 bg-white border border-gray-200
                                rounded-xl shadow-xl z-50 p-2 min-w-[180px]">
                        @foreach($couleurs as $couleur)
                            <label class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg
                                          hover:bg-orange-50 cursor-pointer transition-colors">
                                <input type="checkbox"
                                       wire:model.live="couleur_ids"
                                       value="{{ $couleur->id }}"
                                       class="rounded border-gray-300 text-[#E8490F] focus:ring-[#E8490F]">
                                {{ $couleur->nom_couleur }}
                            </label>
                        @endforeach
                    </div>
                </div>

                {{-- ── Encadrement ── --}}
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                            class="flex items-center gap-1.5 px-3 py-1.5 text-sm border rounded-lg
                                   hover:border-[#E8490F] transition-colors
                                   {{ $encadrement !== null ? 'border-[#E8490F] bg-orange-50 text-[#E8490F] font-semibold' : 'border-gray-300 text-gray-700' }}">
                        Encadrement
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" @click.outside="open = false" x-transition
                         class="absolute top-full left-0 mt-1 bg-white border border-gray-200
                                rounded-xl shadow-xl z-50 p-2 min-w-[170px]">
                        <button wire:click="$set('encadrement', null)" @click="open = false"
                                class="block w-full text-left px-3 py-2 text-sm rounded-lg
                                       hover:bg-orange-50 hover:text-[#E8490F] transition-colors
                                       {{ $encadrement === null ? 'font-bold text-[#E8490F]' : '' }}">
                            Peu importe
                        </button>
                        <button wire:click="$set('encadrement', true)" @click="open = false"
                                class="block w-full text-left px-3 py-2 text-sm rounded-lg
                                       hover:bg-orange-50 hover:text-[#E8490F] transition-colors
                                       {{ $encadrement === true ? 'font-bold text-[#E8490F]' : '' }}">
                            Encadrée
                        </button>
                        <button wire:click="$set('encadrement', false)" @click="open = false"
                                class="block w-full text-left px-3 py-2 text-sm rounded-lg
                                       hover:bg-orange-50 hover:text-[#E8490F] transition-colors
                                       {{ $encadrement === false ? 'font-bold text-[#E8490F]' : '' }}">
                            Non encadrée
                        </button>
                    </div>
                </div>

                {{-- ── Prix (double slider) ── --}}
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                            class="flex items-center gap-1.5 px-3 py-1.5 text-sm border rounded-lg
                                   hover:border-[#E8490F] transition-colors
                                   {{ $prix_min > 0 || $prix_max < 5000 ? 'border-[#E8490F] bg-orange-50 text-[#E8490F] font-semibold' : 'border-gray-300 text-gray-700' }}">
                        Prix
                        @if($prix_min > 0 || $prix_max < 5000)
                            <span class="text-xs">({{ $prix_min }} – {{ $prix_max }} €)</span>
                        @endif
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" @click.outside="open = false" x-transition
                         class="absolute top-full left-0 mt-1 bg-white border border-gray-200
                                rounded-xl shadow-xl z-50 p-4 w-72">

                        <p class="text-xs text-gray-500 mb-4 flex justify-between">
                            <span>Prix</span>
                            <strong class="text-[#E8490F]">{{ $prix_min }} € — {{ $prix_max }} €</strong>
                        </p>

                        {{-- Double slider --}}
                        <div class="relative h-1.5 mb-6"
                             x-data="{
                                 updateRange() {
                                     const min = parseInt(this.$refs.minR.value);
                                     const max = parseInt(this.$refs.maxR.value);
                                     const pct = v => (v / 5000) * 100;
                                     this.$refs.track.style.left  = pct(min) + '%';
                                     this.$refs.track.style.width = (pct(max) - pct(min)) + '%';
                                 }
                             }"
                             x-init="updateRange()">
                            <div class="absolute inset-0 bg-gray-200 rounded-full"></div>
                            <div x-ref="track" class="absolute h-full bg-[#E8490F] rounded-full pointer-events-none"></div>
                            <input type="range" x-ref="minR"
                                   wire:model.live="prix_min"
                                   @input="if(parseInt($event.target.value) > parseInt($refs.maxR.value)-50) $event.target.value = parseInt($refs.maxR.value)-50; updateRange()"
                                   min="0" max="5000" step="50"
                                   class="absolute w-full h-full appearance-none bg-transparent cursor-pointer
                                          pointer-events-none [&::-webkit-slider-thumb]:pointer-events-auto
                                          [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:w-4
                                          [&::-webkit-slider-thumb]:h-4 [&::-webkit-slider-thumb]:rounded-full
                                          [&::-webkit-slider-thumb]:bg-[#E8490F] [&::-webkit-slider-thumb]:border-2
                                          [&::-webkit-slider-thumb]:border-white [&::-webkit-slider-thumb]:shadow-md">
                            <input type="range" x-ref="maxR"
                                   wire:model.live="prix_max"
                                   @input="if(parseInt($event.target.value) < parseInt($refs.minR.value)+50) $event.target.value = parseInt($refs.minR.value)+50; updateRange()"
                                   min="0" max="5000" step="50"
                                   class="absolute w-full h-full appearance-none bg-transparent cursor-pointer
                                          pointer-events-none [&::-webkit-slider-thumb]:pointer-events-auto
                                          [&::-webkit-slider-thumb]:appearance-none [&::-webkit-slider-thumb]:w-4
                                          [&::-webkit-slider-thumb]:h-4 [&::-webkit-slider-thumb]:rounded-full
                                          [&::-webkit-slider-thumb]:bg-[#E8490F] [&::-webkit-slider-thumb]:border-2
                                          [&::-webkit-slider-thumb]:border-white [&::-webkit-slider-thumb]:shadow-md">
                        </div>

                        {{-- Inputs manuels --}}
                        <div class="flex gap-2">
                            <div class="relative flex-1">
                                <span class="absolute left-2 top-1/2 -translate-y-1/2 text-xs text-gray-400">€</span>
                                <input type="number" wire:model.live.debounce="prix_min"
                                       min="0" max="5000" step="50" placeholder="Min"
                                       class="w-full pl-6 pr-2 py-1.5 text-sm border border-gray-300 rounded-lg
                                              focus:outline-none focus:ring-2 focus:ring-[#E8490F]">
                            </div>
                            <span class="text-gray-400 self-center text-sm">—</span>
                            <div class="relative flex-1">
                                <span class="absolute left-2 top-1/2 -translate-y-1/2 text-xs text-gray-400">€</span>
                                <input type="number" wire:model.live.debounce="prix_max"
                                       min="0" max="5000" step="50" placeholder="Max"
                                       class="w-full pl-6 pr-2 py-1.5 text-sm border border-gray-300 rounded-lg
                                              focus:outline-none focus:ring-2 focus:ring-[#E8490F]">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ── Orientation ── --}}
                <div class="flex items-center gap-1.5">
                    <span class="text-xs text-gray-400 mr-1">Format :</span>
                    @foreach([
                        'portrait' => 'M7 3h10v18H7z',
                        'paysage'  => 'M3 7h18v10H3z',
                        'carre'    => 'M4 4h16v16H4z',
                    ] as $val => $path)
                        <button wire:click="$set('orientation', '{{ $orientation === $val ? '' : $val }}')"
                                title="{{ ucfirst($val) }}"
                                class="p-1.5 border rounded-lg transition-colors
                                       {{ $orientation === $val
                                           ? 'border-[#E8490F] bg-orange-50 text-[#E8490F]'
                                           : 'border-gray-300 text-gray-400 hover:border-[#E8490F]' }}">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $path }}"/>
                            </svg>
                        </button>
                    @endforeach
                </div>

            </div>

            {{-- Tags actifs + compteur --}}
            <div class="flex flex-wrap items-center gap-2 mt-3 pt-3 border-t border-gray-100">
                <span class="text-xs text-gray-400">
                    {{ $oeuvres->total() }} œuvre{{ $oeuvres->total() > 1 ? 's' : '' }}
                </span>

                @if($categorie_id)
                    <span class="inline-flex items-center gap-1 bg-[#1A1A1A] text-white text-xs px-3 py-1 rounded-full">
                        {{ $categories->find($categorie_id)?->nom_categorie }}
                        <button wire:click="removeFiltre('categorie')" class="hover:text-red-300 ml-0.5">✕</button>
                    </span>
                @endif

                @foreach($theme_ids as $tid)
                    <span class="inline-flex items-center gap-1 bg-[#1A1A1A] text-white text-xs px-3 py-1 rounded-full">
                        {{ $themes->find($tid)?->nom_theme }}
                        <button wire:click="removeFiltre('theme', {{ $tid }})" class="hover:text-red-300 ml-0.5">✕</button>
                    </span>
                @endforeach

                @foreach($couleur_ids as $cid)
                    <span class="inline-flex items-center gap-1 bg-[#1A1A1A] text-white text-xs px-3 py-1 rounded-full">
                        {{ $couleurs->find($cid)?->nom_couleur }}
                        <button wire:click="removeFiltre('couleur', {{ $cid }})" class="hover:text-red-300 ml-0.5">✕</button>
                    </span>
                @endforeach

                @if($orientation)
                    <span class="inline-flex items-center gap-1 bg-[#1A1A1A] text-white text-xs px-3 py-1 rounded-full capitalize">
                        {{ $orientation }}
                        <button wire:click="removeFiltre('orientation')" class="hover:text-red-300 ml-0.5">✕</button>
                    </span>
                @endif
                @if($encadrement !== null)
                    <span class="inline-flex items-center gap-1 bg-[#1A1A1A] text-white text-xs px-3 py-1 rounded-full">
                        {{ $encadrement ? 'encadrée' : 'non encadrée' }}
                        <button wire:click="removeFiltre('encadrement')" class="hover:text-red-300 ml-0.5">✕</button>
                    </span>
                @endif

                @if($prix_min > 0 || $prix_max < 5000)
                    <span class="inline-flex items-center gap-1 bg-[#1A1A1A] text-white text-xs px-3 py-1 rounded-full">
                        {{ $prix_min }} € – {{ $prix_max }} €
                        <button wire:click="removeFiltre('prix')" class="hover:text-red-300 ml-0.5">✕</button>
                    </span>
                @endif

                @if($this->hasFiltresActifs())
                    <button wire:click="removeAllFiltres"
                            class="text-xs text-red-500 hover:text-red-700 underline ml-1 transition-colors">
                        Supprimer tous les filtres
                    </button>
                @endif
            </div>

        </div>
    </div>
    {{-- Bloc texte SEO --}}
    @if(isset($categorieActive))
        <div class="max-w-screen-xl mx-auto px-4 pt-6" x-data="readmore = false">
            <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 text-sm text-gray-600">
                <p class="font-semibold text-gray-800 mb-1 flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#E8490F]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ $categorieActive->nom_categorie }} en quelques mots
                </p>
                <p>{{ Str::limit($categorieActive->description_courte, 180) }}</p>
                <a href="#description-complete" @click="readmore= true" x-show="!readmore"
                   class="text-[#E8490F] text-xs font-semibold mt-2 inline-flex items-center gap-1">
                    Lire la suite →
                </a>
                
            </div>
        </div>
    @endif
    {{-- ═══════════════════════════════════════════════════
         GRILLE MASONRY
         ═══════════════════════════════════════════════════ --}}
    <div class="max-w-screen-xl mx-auto px-4 py-8">

        @if($oeuvres->count() > 0)
            <div class="columns-2 md:columns-3 lg:columns-4 gap-4">
                @foreach($oeuvres as $oeuvre)
                    @php
                        $tirage      = $oeuvre->tirages->first();
                        $isNew       = $oeuvre->created_at->diffInDays(now()) <= 30;
                        $vendue      = $tirage?->status === 'vendu';
                        $prix        = $tirage?->prix ?? 0;
                        $prixAffiche = $oeuvre->taux_reduction
                            ? $prix * (1 - $oeuvre->taux_reduction)
                            : $prix;
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

            <div class="mt-12">
                {{ $oeuvres->links() }}
            </div>

        @else
            <div class="text-center py-24">
                <p class="text-xl font-bold text-gray-300">Aucune œuvre trouvée</p>
                <p class="text-sm text-gray-400 mt-2">Essayez d'élargir vos filtres</p>
                <button wire:click="removeAllFiltres"
                        class="mt-6 px-6 py-2.5 bg-[#E8490F] text-white text-sm font-bold
                               rounded-lg hover:bg-orange-600 transition-colors">
                    Réinitialiser les filtres
                </button>
            </div>
        @endif

    </div>

    {{-- Indicateur de chargement --}}
    <div wire:loading.flex
         class="fixed inset-0 bg-white/60 z-50 items-center justify-center">
        <svg class="animate-spin w-8 h-8 text-[#E8490F]" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
        </svg>
    </div>
    @if(isset($categorieActive))
        <div id="description-complete" class="bg-gray-50 border border-gray-200 rounded-xl p-4 text-sm text-gray-600 overflow-hidden mx-4" 
        x-show="readmore">
            {{$categorieActive->description_longue}}
            <button @click="readmore = false"
                class="text-xs text-gray-400 hover:text-gray-600 mt-4 block">
            Réduire ↑
        </button>
        </div>
    @endif
</div>

