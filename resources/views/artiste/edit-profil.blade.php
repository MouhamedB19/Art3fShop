@extends('layouts.app')

@section('title', 'Modifier mon profil')

@section('breadcrumb')
    <a href="{{ route('artiste.index.profil') }}" class="hover:text-[#1A1A1A] transition-colors">Mon profil</a>
    <x-mini-fleche/>
    <span class="text-[#1A1A1A] font-medium">Modifier</span>
@endsection

@section('content')
<div class="max-w-screen-xl mx-auto px-4 py-10">

    {{-- En-tête --}}
    <div class="mb-10 border-b border-gray-100 pb-6">
        <p class="text-xs uppercase tracking-widest text-gray-400 mb-1">Espace artiste</p>
        <h1 class="text-3xl font-bold text-[#1A1A1A]">Modifier mon profil</h1>
    </div>

    {{-- Erreurs de validation --}}
    @if ($errors->any())
        <div class="mb-8 bg-red-50 border border-red-200 rounded-xl p-5">
            <p class="text-sm font-semibold text-red-700 mb-2">Corrige les erreurs suivantes :</p>
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li class="text-sm text-red-600">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('artiste.update.profil') }}" method="POST" enctype="multipart/form-data" class="space-y-10">
        @csrf
        @method('PUT')

        {{-- ── SECTION 1 : Infos personnelles ── --}}
        <section>
            <h2 class="text-xs uppercase tracking-widest text-gray-400 mb-5">Informations personnelles</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="nom">Nom</label>
                    <input id="nom" name="nom" type="text"
                           value="{{ old('nom', $user->nom) }}"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1A1A1A] transition @error('nom') border-red-400 @enderror">
                    @error('nom') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="prenom">Prénom</label>
                    <input id="prenom" name="prenom" type="text"
                           value="{{ old('prenom', $user->prenom) }}"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1A1A1A] transition @error('prenom') border-red-400 @enderror">
                    @error('prenom') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="email">Email</label>
                    <input id="email" name="email" type="email"
                           value="{{ old('email', $user->email) }}"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1A1A1A] transition @error('email') border-red-400 @enderror">
                    @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="nom_d_artiste">Nom d'artiste</label>
                    <input id="nom_d_artiste" name="nom_d_artiste" type="text"
                           value="{{ old('nom_d_artiste', $artiste->nom_d_artiste) }}"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1A1A1A] transition @error('nom_d_artiste') border-red-400 @enderror">
                    @error('nom_d_artiste') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

            </div>
        </section>

        {{-- ── SECTION 2 : Mot de passe ── --}}
        <section>
            <h2 class="text-xs uppercase tracking-widest text-gray-400 mb-5">Changer de mot de passe <span class="normal-case text-gray-400">(optionnel)</span></h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="password">Nouveau mot de passe</label>
                    <input id="password" name="password" type="password"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1A1A1A] transition @error('password') border-red-400 @enderror"
                           placeholder="Laisser vide pour ne pas changer">
                    @error('password') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="password_confirmation">Confirmer le mot de passe</label>
                    <input id="password_confirmation" name="password_confirmation" type="password"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1A1A1A] transition">
                </div>

            </div>
        </section>

        {{-- ── SECTION 3 : Profil artistique ── --}}
        <section>
            <h2 class="text-xs uppercase tracking-widest text-gray-400 mb-5">Profil artistique</h2>
            <div class="space-y-5">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="bio">Biographie</label>
                    <textarea id="bio" name="bio" rows="5"
                              class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1A1A1A] transition resize-none @error('bio') border-red-400 @enderror"
                              placeholder="Parlez de votre démarche artistique...">{{ old('bio', $artiste->bio) }}</textarea>
                    @error('bio') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Photo de profil --}}
                <div x-data="{ preview: '{{ $artiste->photo ? Storage::url($artiste->photo) : '' }}' }">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Photo de profil</label>
                    <div class="flex items-center gap-5">
                        <div class="w-20 h-20 rounded-full overflow-hidden bg-gray-100 flex-shrink-0 border border-gray-200">
                            <img x-show="preview" :src="preview" class="w-full h-full object-cover">
                            <div x-show="!preview" class="w-full h-full flex items-center justify-center text-gray-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                        </div>
                        <div>
                            <label for="photo" class="cursor-pointer inline-flex items-center gap-2 text-sm font-medium text-[#1A1A1A] border border-gray-200 rounded-lg px-4 py-2 hover:bg-gray-50 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                                </svg>
                                Changer la photo
                            </label>
                            <input id="photo" name="photo" type="file" accept="image/*" class="hidden"
                                   @change="preview = URL.createObjectURL($event.target.files[0])">
                            <p class="text-xs text-gray-400 mt-1">JPG, PNG, WebP — max 2 Mo</p>
                        </div>
                    </div>
                    @error('photo') <p class="text-xs text-red-500 mt-2">{{ $message }}</p> @enderror
                </div>

                {{-- CV --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="cv">CV / Dossier artistique</label>
                    @if($artiste->CV)
                        <div class="flex items-center gap-2 mb-2 text-sm text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            </svg>
                            <a href="{{ Storage::url($artiste->CV) }}" target="_blank" class="underline hover:text-[#1A1A1A]">Voir le CV actuel</a>
                            <span class="text-gray-300">·</span>
                            <span class="text-xs">Importer un nouveau pour remplacer</span>
                        </div>
                    @endif
                    <input id="cv" name="cv" type="file" accept=".pdf,.doc,.docx"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm file:mr-3 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-medium file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 transition @error('cv') border-red-400 @enderror">
                    <p class="text-xs text-gray-400 mt-1">PDF, DOC, DOCX — max 5 Mo</p>
                    @error('cv') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- IBAN --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="iban">IBAN <span class="text-gray-400 font-normal text-xs">(chiffré et sécurisé)</span></label>
                    <input id="iban" name="iban" type="text"
                           value="{{ old('iban', $artiste->iban) }}"
                           placeholder="FR76 XXXX XXXX XXXX XXXX XXXX XXX"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-[#1A1A1A] transition @error('iban') border-red-400 @enderror">
                    @error('iban') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Catégories --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">Catégories artistiques</label>
                    <div class="flex flex-wrap gap-2">
                        @foreach($categories as $categorie)
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="categories[]" value="{{ $categorie->id }}"
                                       class="w-4 h-4 rounded border-gray-300 text-[#1A1A1A] focus:ring-[#1A1A1A]"
                                       {{ $artiste->categories->contains($categorie->id) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700 border border-gray-200 rounded-full px-3 py-1 hover:bg-gray-50 transition select-none">
                                    {{ $categorie->nom_categorie }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                    @error('categories') <p class="text-xs text-red-500 mt-2">{{ $message }}</p> @enderror
                </div>

            </div>
        </section>

        {{-- ── SECTION 4 : Localisation ── --}}
        <section>
            <h2 class="text-xs uppercase tracking-widest text-gray-400 mb-5">Localisation</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="adresse">Adresse</label>
                    <input id="adresse" name="adresse" type="text"
                           value="{{ old('adresse', $artiste->localisation?->adresse) }}"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1A1A1A] transition @error('adresse') border-red-400 @enderror">
                    @error('adresse') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="code_postal">Code postal</label>
                    <input id="code_postal" name="code_postal" type="text"
                           value="{{ old('code_postal', $artiste->localisation?->code_postal) }}"
                           class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1A1A1A] transition @error('code_postal') border-red-400 @enderror">
                    @error('code_postal') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="ville_id">Ville</label>
                    <select id="ville_id" name="ville_id"
                            class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#1A1A1A] transition bg-white @error('ville_id') border-red-400 @enderror">
                        <option value="">Sélectionner une ville</option>
                        @foreach($villes as $ville)
                            <option value="{{ $ville->id }}"
                                {{ old('ville_id', $artiste->localisation?->ville_id) == $ville->id ? 'selected' : '' }}>
                                {{ $ville->nom_ville }}
                            </option>
                        @endforeach
                    </select>
                    @error('ville_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

            </div>
        </section>

        {{-- ── Actions ── --}}
        <div class="flex items-center justify-between pt-6 border-t border-gray-100">
            <a href="{{ route('artiste.index.profil') }}"
               class="text-sm text-gray-500 hover:text-[#1A1A1A] transition">
                ← Annuler
            </a>
            
            <button type="submit"
                    class="bg-[#1A1A1A] text-white text-sm font-medium px-8 py-3 rounded-lg hover:bg-gray-800 active:scale-95 transition-all">
                Enregistrer les modifications
            </button>
            
        </div>

    </form>
</div>
@endsection