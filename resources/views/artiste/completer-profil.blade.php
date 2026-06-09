@extends('layouts.app')
@section('content')
    <x-guest-layout>
        <form method="POST" action="{{ route('artiste.completer-profil.store') }}" enctype="multipart/form-data">
            @csrf

            <!-- Nom d'artiste -->
            <div>
                <x-input-label for="nom_d_artiste">Nom d'artiste (optionnel)</x-input-label>
                <input type="text" name="nom_d_artiste" id="nom_d_artiste" class="w-full" value="{{ old('nom_d_artiste') }}" class="block mt-1 w-full border-radius-10">
                @error('nom_d_artiste') <span>{{ $message }}</span> @enderror
            </div>


            <!-- Bio -->
            <div >
                <x-input-label for="bio">Bio</x-input-label>
                <textarea name="bio" id="bio" class="block mt-1 w-full border-radius-10">{{ old('bio') }}</textarea>
                @error('bio') <span>{{ $message }}</span> @enderror
            </div>

            <!-- Photo -->
            <div>
                <x-input-label for="photo">Photo de profil</x-input-label>
                <input type="file" name="photo" id="photo" accept="image/*" class="block mt-1 w-full border-radius-10">
                @error('photo') <span>{{ $message }}</span> @enderror
            </div>

            <!-- IBAN -->
            <div>
                <x-input-label for="iban">IBAN</x-input-label>
                <input type="text" name="iban" id="iban" class="w-full" value="{{ old('iban') }}">
                @error('iban') <span>{{ $message }}</span> @enderror      
            </div>

            <!-- Pays -->
            <div>
                <x-input-label for="pays_id">Pays</x-input-label>
                <select name="pays_id" id="pays_id" class="w-full">
                    <option value="">-- Choisir un pays --</option>
                    @foreach($pays as $p)
                        <option value="{{ $p->id }}">{{ $p->nom_pays }}</option>
                    @endforeach
                </select>
                @error('pays_id') <span>{{ $message }}</span> @enderror
            </div>

            <!-- Ville (se remplit selon le pays choisi) -->
            <div>
                <x-input-label for="ville_id">Ville</x-input-label>
                <select name="ville_id" id="ville_id" class="w-full">
                    <option value="">-- Choisir d'abord un pays --</option>

                </select>
                @error('ville_id') <span>{{ $message }}</span> @enderror
            </div>

            <!-- Code postal -->
            <div>
                <x-input-label for="code_postal">Code postal</x-input-label>
                <input type="text" name="code_postal" id="code_postal" class="w-full" value="{{ old('code_postal') }}">
                @error('code_postal') <span>{{ $message }}</span> @enderror
            </div>

            <!-- Adresse -->
            <div>
                <x-input-label for="adresse">Adresse</x-input-label>
                <input type="text" name="adresse" id="adresse" class="w-full" value="{{ old('adresse') }}">
                @error('adresse') <span>{{ $message }}</span> @enderror
            </div>
            <div>
                <x-input-label for="categories">
                    Catégorie(s) artistique(s)
                </x-input-label>
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" type="button"
                            class="flex items-center justify-between gap-1.5 px-3 py-2 text-sm border rounded-lg
                                   hover:border-[#E8490F] w-full transition-colors">
                        <span>Catégories</span>
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open" @click.outside="open = false" x-transition
                         class="absolute top-full left-0 mt-1 bg-white border w-full border-gray-200
                                rounded-xl shadow-xl z-50 p-2 min-w-[200px]">

                        @foreach($categories as $cat)
                            <label class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg
                                              hover:bg-orange-50 cursor-pointer transition-colors">
                                <input type="checkbox"                               
                                       value="{{ $cat->id }}"
                                       name="categories[]"
                                       class="rounded border-gray-300 text-[#E8490F] focus:ring-[#E8490F]">
                                {{ $cat->nom_categorie }}
                            </label>
                        @endforeach
                    </div>
                </div>

            </div>

            <!-- CV -->
            <div>
                <x-input-label for="cv">CV (PDF, DOC ou DOCX)</x-input-label>
                <input type="file" name="cv" id="cv" accept=".pdf,.doc,.docx">
                @error('cv') <span>{{ $message }}</span> @enderror
            </div>

            <x-primary-button type="submit">Enregistrer mon profil</x-primary-button>
        </form>
    </x-guest-layout>
    <script>
    document.getElementById('pays_id').addEventListener('change', function() {
        const pays_id = this.value;
        const villeSelect = document.getElementById('ville_id');

        villeSelect.innerHTML = '<option value="">Chargement...</option>';

        fetch(`/villes/${pays_id}`)
            .then(response => response.json())
            .then(villes => {
                villeSelect.innerHTML = '<option value="">-- Choisir une ville --</option>';
                villes.forEach(ville => {
                    villeSelect.innerHTML += `<option value="${ville.id}">${ville.nom_ville}</option>`;
                });
            });
    });
    </script>
@endsection