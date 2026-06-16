@extends('layouts.app')

@section('title', 'Commande #' . $commande->id)

@section('breadcrumb')
    <a href="{{ route('home') }}" class="hover:text-[#E8490F]">Accueil</a>
    <x-mini-fleche/>
    <a href="{{ route('compte.index') }}" class="hover:text-[#E8490F]">Mon compte</a>
    <x-mini-fleche/>
    <a href="{{ route('compte.commandes.index') }}" class="hover:text-[#E8490F]">Mes commandes</a>
    <x-mini-fleche/>
    <span class="text-[#1A1A1A]">Commande #{{ $commande->id }}</span>
@endsection

@section('content')
    <div class="max-w-screen-md mx-auto px-4 py-10">

        {{-- En-tête --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-semibold">Commande #{{ $commande->id }}</h1>
                <p class="text-sm text-gray-500 mt-1">Passée le {{ $commande->date_commande->format('d/m/Y') }}</p>
            </div>
        </div>

        {{-- Tirages --}}
        <div class="flex flex-col gap-4 mb-10">
            @foreach($commande->tirages as $tirage)
                @php $oeuvre = $tirage->oeuvre; @endphp
                <div class="border border-gray-200 rounded-2xl p-5 flex gap-5 items-start">

                    {{-- Photo œuvre --}}
                    @if($oeuvre->photo)
                        <img src="{{ asset('storage/' . $oeuvre->photo) }}"
                             alt="{{ $oeuvre->titre }}"
                             class="w-24 h-24 object-cover rounded-xl shrink-0">
                    @else
                        <div class="w-24 h-24 bg-gray-100 rounded-xl shrink-0 flex items-center justify-center">
                            <span class="text-gray-400 text-xs">No image</span>
                        </div>
                    @endif

                    {{-- Infos --}}
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-[#1A1A1A]">{{ $oeuvre->titre }}</p>
                        <p class="text-sm text-gray-500 mt-0.5">
                            par <span class="font-medium">{{ $oeuvre->artiste->user->nom}} {{ $oeuvre->artiste->user->prenom }}</span>
                        </p>
                        <div class="flex flex-wrap gap-3 mt-3 text-sm text-gray-600">
                            <span>Tirage n°{{ $tirage->numero }}</span>
                            @if($tirage->avec_cadre)
                                <span>· Avec cadre</span>
                            @endif
                            @if($tirage->pret_a_accrocher)
                                <span>· Prêt à accrocher</span>
                            @endif
                            <span class="font-semibold text-[#1A1A1A]">{{ number_format($tirage->prix, 2, ',', ' ') }} €</span>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>

        {{-- Livraisons --}}
        @if($commande->livraisons->isNotEmpty())
            <div class="border border-gray-200 rounded-2xl p-5 mb-6">
                <h2 class="font-semibold mb-3">Livraison</h2>
                @foreach($commande->livraisons as $livraison)
                    <p class="text-sm text-gray-600">{{ $livraison->adresse ?? 'Adresse non renseignée' }}</p>
                @endforeach
            </div>
        @endif

        {{-- Bouton contacter l'artiste --}}
        @php
            $artistes = $commande->tirages
                        ->map(fn($t) => $t->oeuvre?->artiste)
                        ->filter()
                        ->unique('id');
            $conversation = $commande->conversation;
        @endphp

        @if($artistes)
            
            <div class="border border-gray-200 rounded-2xl p-5">
                <h2 class="font-semibold mb-1">Un problème avec cette commande ?</h2>
                <p class="text-sm text-gray-500 mb-4">Contactez directement l'artiste pour toute question liée à la livraison.</p>

                @if($conversation)
                    <a href="{{ route('conversations.show', $conversation) }}"
                       class="inline-flex items-center gap-2 bg-[#E8490F] hover:bg-[#cf3e0c] text-white text-sm font-medium px-5 py-3 rounded-xl transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
                        </svg>
                        Voir la conversation
                    </a>
                @else

                    @foreach($artistes as $artiste)
                        <form action="{{ route('conversations.store',[$commande->id,$artiste->id]) }}" method="POST">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-2 bg-[#E8490F] rounded p-2 m-1 hover:bg-gray-400">
                                <x-logo-message/>
                                Contacter {{ $artiste->nom_d_artiste }}
                            </button>
                        </form>
                    @endforeach
                @endif
            </div>
        @endif

    </div>
@endsection