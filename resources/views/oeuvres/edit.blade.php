@if($errors->any())
    <div>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<a href="{{ route('oeuvres.index') }}">Retour à la liste</a>
<a href="{{ route('dashboard') }}">Retour au tableau de bord</a>
<h1>Modifier l'oeuvre : {{ $oeuvre->titre }}</h1>
<form method="POST" action="{{ route('oeuvres.update', $oeuvre->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')  

    <!-- Titre avec valeur pré-remplie -->
    <label for="titre">Titre</label>
    <input type="text" name="titre" value="{{ old('titre', $oeuvre->titre) }}">
    <br>


    <!-- Catégorie avec option sélectionnée -->
    <label for="categorie_id">Catégorie</label>
    <select name="categorie_id" id="categorie_parent_id">
        <option value="">-- Choisir --</option>
        @foreach($categories as $categorie)
            <option value="{{ $categorie->id }}" {{ (old('categorie_id', $oeuvre->categorie_id) == $categorie->id) ? 'selected' : '' }}>
                {{ $categorie->nom_categorie }}
            </option>
        @endforeach
    </select>
    <br>
    <div id="sous-categorie-div" style="display:block">
        <label for="categorie_id">Sous-catégorie</label>
        <select name="categorie_id" id="categorie_id">
            <option value="">-- Choisir --</option>
        </select>
    </div>


    <!-- Cases cochées selon les thèmes déjà associés -->
    <label>Thèmes</label>
    <br>
    @foreach($themes as $theme)
        <input type="checkbox" name="themes[]" value="{{ $theme->id }}"
            {{ $oeuvre->themes->contains($theme->id) ? 'checked' : '' }}>
        <label>{{ $theme->nom_theme }}</label>
    @endforeach
    <br>


    <!-- Cases cochées selon les couleurs déjà associées -->
    <label>Couleurs</label>
    <br>
    @foreach($couleurs as $couleur)
        <input type="checkbox" name="couleurs[]" value="{{ $couleur->id }}"
            {{ $oeuvre->couleurs->contains($couleur->id) ? 'checked' : '' }}>
        <label>{{ $couleur->nom_couleur }}</label>
    @endforeach
    <br>


    <!-- Photo principale -->
    <label for="photo_principale">Photo principale</label>
    <input type="file" name="photo_principale" id="photo_principale">
    @error('photo_principale') <span>{{ $message }}</span> @enderror
    <img src="{{ asset('storage/' . $oeuvre->photo_principale) }}" alt="{{ $oeuvre->titre }}" width="100">
    <br>

    <!-- Support -->
    <label for="support_id">Support</label>
    <select name="support_id" id="support_id">
        <option value="">-- Choisir --</option>
        @foreach($supports as $support)
            <option value="{{ $support->id }}" {{ (old('support_id', $oeuvre->support_id) == $support->id) ? 'selected' : '' }}>
                {{ $support->nom_support }}
            </option>
        @endforeach
    </select>
    @error('support_id') <span>{{ $message }}</span> @enderror
    <br>
    
    
    <!-- Description avec valeur pré-remplie -->
    <label>Description</label>
    <textarea name="description">{{ old('description', $oeuvre->description) }}</textarea>
    @error('description') <span>{{ $message }}</span> @enderror
    <br>
    <!-- Orientation -->
    <div id="orientation-div" style="display:none">
        <label for="orientation">Orientation</label>
        <select name="orientation" id="orientation">
            <option value="">-- Choisir --</option>
            <option value="Portrait" {{ (old('orientation', $oeuvre->orientation) == 'Portrait') ? 'selected' : '' }}>Portrait</option>
            <option value="Paysage" {{ (old('orientation', $oeuvre->orientation) == 'Paysage') ? 'selected' : '' }}>Paysage</option>
            <option value="Carré" {{ (old('orientation', $oeuvre->orientation) == 'Carré') ? 'selected' : '' }}>Carré</option>
        </select>
    </div>
    <div id="encadrement-div" style="display:none">
        <input type="checkbox" name="encadrement" id="encadrement" value="1" checked="{{ old('encadrement', $oeuvre->encadrement) ? 'checked' : '' }}">
        <label for="encadrement">Vendu avec cadre</label>
    </div>
    <button type="submit">Mettre à jour</button>
</form>




<script>
    const sousCatDiv = document.getElementById('sous-categorie-div');
    const sousCatSelect = document.getElementById('categorie_id');
    // Au chargement de la page, charge les sous-catégories de la catégorie parente
    document.addEventListener('DOMContentLoaded', function() {
        const categorieParente = {{ $oeuvre->categorie->id_categorie_parente ?? 'null' }};
        document.getElementById('categorie_parent_id').value = {{ $oeuvre->categorie->id_categorie_parente ?? 'null' }};
        if(categorieParente) {
            fetch(`/categories/${categorieParente}/sous-categories`)
                .then(r => r.json())
                .then(sousCats => {
                    const sousCatSelect = document.getElementById('categorie_id');
                    sousCatSelect.innerHTML = '<option value="">-- Choisir --</option>';
                    sousCats.forEach(sc => {
                        sousCatSelect.innerHTML += `<option value="${sc.id}" 
                            ${sc.id == {{ $oeuvre->categorie_id }} ? 'selected' : ''}>
                            ${sc.nom_categorie}
                        </option>`;
                    });
                    document.getElementById('sous-categorie-div').style.display = 'block';
                });
        }
    });


    document.getElementById('categorie_parent_id').addEventListener('change', function() {
        const categorie_id = this.value;
        
        if(!categorie_id) {
            sousCatDiv.style.display = 'none';
            document.getElementById('technique-div').style.display = 'none';
            return;
        }
        const orientationDiv = document.getElementById('orientation-div');
        const encadrementDiv = document.getElementById('encadrement-div');

        const selectedOption = this.options[this.selectedIndex];
        const selectedText = selectedOption.text;

        if(selectedText === 'Sculpture') {
            orientationDiv.style.display = 'none';
            encadrementDiv.style.display = 'none';
        } 
        else {
            orientationDiv.style.display = 'flex';
            encadrementDiv.style.display = 'block';
        }
        fetch(`/categories/${categorie_id}/sous-categories`)
            .then(r => r.json())
            .then(sousCats => {
                if(sousCats.length === 0) 
                {
                    // Pas de sous-catégories, on utilise la catégorie principale
                    sousCatDiv.style.display = 'none';
                    // Copie la valeur dans un champ caché
                    document.getElementById('categorie_id').value = categorie_id;
                } 
                else 
                {
                    sousCatDiv.style.display = 'block';
                    sousCatSelect.innerHTML = '<option value="">-- Choisir --</option>';
                    sousCats.forEach(sc => {
                        sousCatSelect.innerHTML += `<option value="${sc.id}" ${sc.id == {{ $oeuvre->categorie_id }} ? 'selected' : ''}>${sc.nom_categorie}</option>`;
                    });

                    /*document.getElementById('categorie_parent_id').addEventListener('change', function() {
                        const selectedOption = this.options[this.selectedIndex];
                        const selectedText = selectedOption.text;
                        const technique = selectedOption.dataset.technique;
                        
                        const techniqueDiv = document.getElementById('technique-div');
                        if(technique) {
                            techniqueDiv.style.display = 'block';
                            document.getElementById('technique-label').textContent = technique;
                        } else {
                            techniqueDiv.style.display = 'none';
                        }
                    });*/
                }
            });
    });
</script>
