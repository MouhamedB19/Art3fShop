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
<h1>Ajouter une oeuvre</h1>
<form method="POST" action="{{ route('oeuvres.store') }}" enctype="multipart/form-data">
    @csrf

    <!-- Titre -->
    <div>
        <label for="titre">Titre</label>
        <input type="text" name="titre" id="titre" value="{{ old('titre') }}">
        @error('titre') <span>{{ $message }}</span> @enderror
    </div>

    <!-- Année de création -->
    <div>
        <label for="annee_creation">Année de création</label>
        <input type="number" name="annee_de_creation" id="annee_creation" value="{{ old('annee_de_creation') }}">
        @error('annee_creation') <span>{{ $message }}</span> @enderror
    </div>

    <!-- Catégorie -->
    <div>
        <label for="categorie_id">Catégorie</label>
        <select name="categorie_id" id="categorie_parent_id">
            <option value="">-- Choisir --</option>
            @foreach($categories as $categorie)
                <option value="{{ $categorie->id }}">{{ $categorie->nom_categorie }}</option>
            @endforeach
        </select>
        <div id="sous-categorie-div" style="display:none">
            <label for="categorie_id">Sous-catégorie</label>
            <select name="categorie_id" id="categorie_id">
                <option value="">-- Choisir --</option>
            </select>
        </div>
        <div id="technique-div" style="display:none">
            <label>Technique</label>
            <p id="technique-label"></p>
        </div>
        @error('categorie_id') <span>{{ $message }}</span> @enderror
    </div>

    <!-- Support -->
    <div>
        <label for="support_id">Support</label>
        <select name="support_id" id="support_id">
            <option value="">-- Choisir --</option>
            @foreach($supports as $support)
                <option value="{{ $support->id }}">{{ $support->nom_support }}</option>
            @endforeach
        </select>
        @error('support_id') <span>{{ $message }}</span> @enderror
    </div>

    <!-- Thèmes -->
    <div>
        <label>Thèmes</label>
        @foreach($themes as $theme)
            <input type="checkbox" name="themes[]" value="{{ $theme->id }}">
            <label>{{ $theme->nom_theme }}</label>
        @endforeach
    </div>

    <!-- Couleurs -->
    <div>
        <label>Couleurs</label>
        @foreach($couleurs as $couleur)
            
            <input type="checkbox" name="couleurs[]" value="{{ $couleur->id }}">
            <label>    
                {{ $couleur->nom_couleur }}
            </label>
        @endforeach
    </div>

    <!-- Orientation -->
    <div id="orientation-div">
        <label for="orientation">Orientation</label>
        <select name="orientation" id="orientation">
            <option value="portrait">Portrait</option>
            <option value="paysage">Paysage</option>
            <option value="carre">Carré</option>
        </select>
    </div>

    <!-- Photo principale -->
    <div>
        <label for="photo_principale">Photo principale</label>
        <input type="file" name="photo_principale" id="photo_principale" accept="image/*">
        @error('photo_principale') <span>{{ $message }}</span> @enderror
    </div>

    <!-- Description -->
    <div>
        <label for="description">Description</label>
        <textarea name="description" id="description">{{ old('description') }}</textarea>
        @error('description') <span>{{ $message }}</span> @enderror
    </div>

    <!-- Encadrement -->
    <div id="encadrement-div">
            <input type="checkbox" name="encadrement" value="1">
            <label>
            Vendu avec cadre
        </label>
    </div>

    <button type="submit">Ajouter l'œuvre</button>
</form>
<script>
    document.getElementById('categorie_parent_id').addEventListener('change', function() {
        const categorie_id = this.value;
        const sousCatDiv = document.getElementById('sous-categorie-div');
        const sousCatSelect = document.getElementById('categorie_id');

        if(!categorie_id) {
            sousCatDiv.style.display = 'none';
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
                        sousCatSelect.innerHTML += `<option value="${sc.id}">${sc.nom_categorie}</option>`;
                    });

                    document.getElementById('categorie_parent_id').addEventListener('change', function() {
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
                    });
                }
            });
                        
    });
</script>