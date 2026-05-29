<form method="GET" action="{{ route('catalogue.index') }}">
    <div>
        <input type="text" name="recherche" 
               placeholder="Artiste, œuvre..." 
               value="{{ request('recherche') }}">
    </div>
    <select name="categorie_id">
        <option value="">Toutes les catégories</option>
        @foreach($categories as $categorie)
            <option value="{{ $categorie->id }}" {{ request('categorie_id') == $categorie->id ? 'selected' : '' }}>
                {{ $categorie->nom_categorie }}
            </option>
        @endforeach
    </select>
    
    <select name="theme_id">
        <option value="">Tous les thèmes</option>
        @foreach($themes as $theme)
            <option value="{{ $theme->id }}" {{ request('theme_id') == $theme->id ? 'selected' : '' }}>
                {{ $theme->nom_theme }}
            </option>
        @endforeach
    </select>
    <select name="couleur_id">
        <option value="">Toutes les couleurs</option>
        @foreach($couleurs as $couleur)
            <option value="{{ $couleur->id }}" {{ request('couleur_id') == $couleur->id ? 'selected' : '' }}>
                {{ $couleur->nom_couleur }}
            </option>
        @endforeach
    </select>
    <select name="orientation">
        <option value="">Toutes les orientations</option>
        <option value="portrait" {{ request('orientation') == 'portrait' ? 'selected' : '' }}>Portrait</option>
        <option value="paysage" {{ request('orientation') == 'paysage' ? 'selected' : '' }}>Paysage</option>
        <option value="carre" {{ request('orientation') == 'carre' ? 'selected' : '' }}>Carré</option>
    </select>
    <div>
        <label>Année</label>
        <input type="number" name="annee_min" placeholder="De" value="{{ request('annee_min') }}">
        <input type="number" name="annee_max" placeholder="À" value="{{ request('annee_max') }}">
    </div>
    <button type="submit">Rechercher</button>
</form>
@foreach($oeuvres as $oeuvre)
    <div>
        <img src="{{ asset('storage/'.$oeuvre->photo_principale) }}" alt="{{ $oeuvre->titre }}">
        <p>{{ $oeuvre->titre }}</p>
        <p>{{ $oeuvre->artiste->user->prenom }}  {{ $oeuvre->artiste->user->nom }}</p>
    </div>
@endforeach

{{ $oeuvres->links() }}