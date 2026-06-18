@extends('layouts.app')

@section('title', 'Mon profil')

@section('breadcrumb')
    <a href="{{ route('home') }}" class="hover:text-[#E8490F] transition-colors">Accueil</a>
    <x-mini-fleche />
    <a href="{{ route('compte.index') }}" class="hover:text-[#E8490F] transition-colors">Mon compte</a>
    <x-mini-fleche/>
    <span class="text-[#1A1A1A] font-medium">Index du profil</span>
@endsection

@section('content')
    <div class="max-w-screen-xl mx-auto px-4 py-10">

        {{-- Message de succès --}}
        @if(session('success'))
            <div class="mb-8 bg-green-50 border border-green-200 rounded-xl px-5 py-4 flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <p class="text-sm text-green-700">{{ session('success') }}</p>
            </div>
        @endif

        {{-- En-tête profil --}}
        <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-6 mb-10 pb-8 border-b border-gray-100">
            <div class="flex items-center gap-6">
                {{-- Avatar --}}
                <div class="w-24 h-24 rounded-full overflow-hidden bg-gray-100 border border-gray-200 flex-shrink-0">
                    @if($user->artiste?->photo)
                        <img src="{{ Storage::url($user->artiste->photo) }}"
                             alt="{{ $user->artiste->nom_d_artiste ?? $user->prenom }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                    @endif
                </div>

                <div>
                    <p class="text-xs uppercase tracking-widest text-gray-400 mb-0.5">Espace artiste</p>
                    <h1 class="text-3xl font-bold text-[#1A1A1A]">
                        {{ $user->artiste?->nom_d_artiste ?? $user->prenom . ' ' . $user->nom }}
                    </h1>
                    @if($user->artiste?->nom_d_artiste)
                        <p class="text-sm text-gray-500 mt-0.5">{{ $user->prenom }} {{ $user->nom }}</p>
                    @endif

                    {{-- Catégories --}}
                    @if($user->artiste?->categories?->count())
                        <div class="flex flex-wrap gap-1.5 mt-2">
                            @foreach($user->artiste->categories as $cat)
                                <span class="text-xs border border-gray-200 text-gray-600 rounded-full px-2.5 py-0.5">{{ $cat->nom_categorie }}</span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <a href="{{ route('artiste.edit.profil') }}"
               class="inline-flex items-center gap-2 text-sm font-medium bg-[#1A1A1A] text-white px-5 py-2.5 rounded-lg hover:bg-gray-800 transition self-start md:self-auto">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                </svg>
                Modifier le profil
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Colonne principale --}}
            <div class="lg:col-span-2 space-y-8">

                {{-- Bio --}}
                <div class="bg-gray-50 rounded-2xl p-6">
                    <h2 class="text-xs uppercase tracking-widest text-gray-400 mb-4">Biographie</h2>
                    @if($user->artiste?->bio)
                        <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">{{ $user->artiste->bio }}</p>
                    @else
                        <p class="text-sm text-gray-400 italic">Aucune biographie renseignée.</p>
                    @endif
                </div>

                {{-- Infos personnelles --}}
                <div>
                    <h2 class="text-xs uppercase tracking-widest text-gray-400 mb-4">Informations personnelles</h2>
                    <div class="divide-y divide-gray-100">

                        <div class="flex justify-between items-center py-3">
                            <span class="text-sm text-gray-500">Nom complet</span>
                            <span class="text-sm font-medium text-[#1A1A1A]">{{ $user->prenom }} {{ $user->nom }}</span>
                        </div>

                        <div class="flex justify-between items-center py-3">
                            <span class="text-sm text-gray-500">Adresse email</span>
                            <span class="text-sm font-medium text-[#1A1A1A]">{{ $user->email }}</span>
                        </div>

                        @if($user->artiste?->localisation)
                            <div class="flex justify-between items-center py-3">
                                <span class="text-sm text-gray-500">Adresse</span>
                                <span class="text-sm font-medium text-[#1A1A1A] text-right">
                                    {{ $user->artiste->localisation->adresse }}<br>
                                    <span class="text-gray-500 font-normal">{{ $user->artiste->localisation->code_postal }}
                                        {{ $user->artiste->localisation->ville?->nom }}</span>
                                </span>
                            </div>
                        @endif

                    </div>
                </div>

            </div>

            {{-- Colonne latérale --}}
            <div class="space-y-6">

                {{-- Statut Art3f --}}
                <div class="border border-gray-200 rounded-2xl p-5">
                    <h2 class="text-xs uppercase tracking-widest text-gray-400 mb-3">Statut</h2>
                    @if($user->artiste?->Est_Artiste_Art3f)
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-green-400"></span>
                            <span class="text-sm font-medium text-green-700">Artiste Art3f certifié</span>
                        </div>
                    @else
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                            <span class="text-sm font-medium text-amber-700">En attente de certification</span>
                        </div>
                    @endif
                </div>

                {{-- CV --}}
                <div class="border border-gray-200 rounded-2xl p-5">
                    <h2 class="text-xs uppercase tracking-widest text-gray-400 mb-3">Dossier artistique</h2>
                    @if($user->artiste?->CV)
                        <a href="{{ Storage::url($user->artiste->CV) }}" target="_blank"
                           class="inline-flex items-center gap-2 text-sm font-medium text-[#1A1A1A] hover:underline">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                            Voir mon CV
                        </a>
                    @else
                        <p class="text-sm text-gray-400 italic">Aucun CV importé.</p>
                    @endif
                </div>

                {{-- IBAN (masqué) --}}
                <div class="border border-gray-200 rounded-2xl p-5">
                    <h2 class="text-xs uppercase tracking-widest text-gray-400 mb-3">Coordonnées bancaires</h2>
                    @if($user->artiste?->iban)
                        <p class="text-sm font-mono text-gray-600 tracking-wider">
                            •••• •••• •••• {{ substr($user->artiste->iban, -4) }}
                        </p>
                        <p class="text-xs text-gray-400 mt-1">IBAN chiffré et sécurisé</p>
                    @else
                        <p class="text-sm text-gray-400 italic">Aucun IBAN renseigné.</p>
                    @endif
                </div>

                {{-- Liens rapides --}}
                <div class="border border-gray-200 rounded-2xl p-5">
                    <h2 class="text-xs uppercase tracking-widest text-gray-400 mb-3">Accès rapide</h2>
                    <nav class="space-y-2">
                        <a href="{{ route('oeuvres.index') }}"
                           class="flex items-center justify-between text-sm text-gray-700 hover:text-[#1A1A1A] transition py-1 group">
                            <span>Mes œuvres</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-300 group-hover:text-gray-500 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                        <a href="{{ route('compte.conversations.index') }}"
                           class="flex items-center justify-between text-sm text-gray-700 hover:text-[#1A1A1A] transition py-1 group">
                            <span>Mes messages</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-300 group-hover:text-gray-500 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </nav>
                </div>

            </div>
        </div>
    </div>
@endsection