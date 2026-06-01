<x-guest-layout>
    <form method="POST" action="{{ route('artiste.completer-profil.store') }}" enctype="multipart/form-data">
        @csrf

        <!-- Nom d'artiste -->
        <div>
            <x-input-label for="nom_d_artiste">Nom d'artiste (optionnel)</x-input-label>
            <input type="text" name="nom_d_artiste" id="nom_d_artiste" value="{{ old('nom_d_artiste') }}" class="block mt-1 w-full border-radius-10">
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
            <input type="text" name="iban" id="iban" value="{{ old('iban') }}">
            @error('iban') <span>{{ $message }}</span> @enderror      
        </div>

        <!-- Pays -->
        <div>
            <x-input-label for="pays_id">Pays</x-input-label>
            <select name="pays_id" id="pays_id">
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
            <select name="ville_id" id="ville_id">
                <option value="">-- Choisir d'abord un pays --</option>
                
            </select>
            @error('ville_id') <span>{{ $message }}</span> @enderror
        </div>

        <!-- Code postal -->
        <div>
            <x-input-label for="code_postal">Code postal</x-input-label>
            <input type="text" name="code_postal" id="code_postal" value="{{ old('code_postal') }}">
            @error('code_postal') <span>{{ $message }}</span> @enderror
        </div>

        <!-- Adresse -->
        <div>
            <x-input-label for="adresse">Adresse</x-input-label>
            <input type="text" name="adresse" id="adresse" value="{{ old('adresse') }}">
            @error('adresse') <span>{{ $message }}</span> @enderror
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