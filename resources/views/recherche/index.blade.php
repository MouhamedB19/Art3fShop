@extends('layouts.app')

@section('content')

    <div class="max-w-6xl mx-auto px-4 py-10">

        <h1 class="text-2xl font-bold mb-8">
            Résultats pour "<span class="text-[#E8490F]">{{ $terme }}</span>"
        </h1>

        {{-- ŒUVRES --}}
        <section class="mb-12">
            <h2 class="text-lg font-semibold mb-4">
                Œuvres
                <span class="text-gray-400 text-sm font-normal">({{ $oeuvres->total() }})</span>
            </h2>

            @if($oeuvres->isEmpty())
                <p class="text-gray-400">Aucune œuvre trouvée.</p>
            @else
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach($oeuvres as $oeuvre)
                        @php
                            $prixMin = $oeuvre->tirages->where('status', 'disponible')->min('prix');
                        @endphp
                        <a href="{{ route('oeuvres.show', $oeuvre) }}" class="block group">
                            <div class="aspect-square rounded-2xl overflow-hidden bg-gray-100 mb-2">
                                <img src="{{ asset('storage/' . $oeuvre->image) }}" alt="{{ $oeuvre->titre }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            </div>
                            <p class="text-sm font-medium text-gray-900">{{ $oeuvre->titre }}</p>
                            <p class="text-xs text-gray-500">
                                {{ $oeuvre->artiste?->nom_d_artiste ?: ($oeuvre->artiste?->user->nom . ' ' . $oeuvre->artiste?->user->prenom) }}
                            </p>
                            <p class="text-sm font-bold {{ $prixMin ? 'text-[#E8490F]' : 'text-gray-400' }}">
                                {{ $prixMin ? number_format($prixMin, 2) . ' €' : 'Vendu' }}
                            </p>
                        </a>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $oeuvres->onEachSide(1)->links() }}
                </div>
            @endif
        </section>

        {{-- ARTISTES --}}
        <section class="mb-12">
            <h2 class="text-lg font-semibold mb-4">
                Artistes
                <span class="text-gray-400 text-sm font-normal">({{ $artistes->total() }})</span>
            </h2>

            @if($artistes->isEmpty())
                <p class="text-gray-400">Aucun artiste trouvé.</p>
            @else
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach($artistes as $artiste)
                        <a href="{{ route('artistes.show', $artiste) }}" class="flex items-center gap-3 group">
                            <img src="{{ asset('storage/' . $artiste->photo) }}" alt="{{ $artiste->nom_d_artiste }}"
                                class="w-12 h-12 rounded-full object-cover">
                            <div>
                                <p class="text-sm font-medium text-gray-900 group-hover:text-[#E8490F]">
                                    {{ $artiste->nom_d_artiste ?: $artiste->user->nom . ' ' . $artiste->user->prenom }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ $artiste->localisation?->ville->nom_ville }}
                                    @if($artiste->localisation?->ville->pays)
                                        · {{ $artiste->localisation->ville->pays->nom_pays }}
                                    @endif
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $artistes->onEachSide(1)->links() }}
                </div>
            @endif
        </section>

        {{-- CATÉGORIES --}}
        <section>
            <h2 class="text-lg font-semibold mb-4">
                Catégories
                <span class="text-gray-400 text-sm font-normal">({{ $categories->count() }})</span>
            </h2>

            @if($categories->isEmpty())
                <p class="text-gray-400">Aucune catégorie trouvée.</p>
            @else
                <div class="flex flex-wrap gap-3">
                    @foreach($categories as $categorie)
                        <a href="{{ route('catalogue.categorie', $categorie->nom_categorie) }}"
                            class="px-4 py-2 rounded-2xl bg-gray-100 text-sm text-gray-700 hover:bg-[#E8490F] hover:text-white transition">
                            {{ $categorie->nom_categorie }}
                        </a>
                    @endforeach
                </div>
            @endif
        </section>

    </div>

@endsection