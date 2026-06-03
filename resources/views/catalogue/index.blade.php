<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'art3f Shop') — Art Contemporain</title>
    <meta name="description"
          content="@yield('meta_description', 'art3f Shop — Achetez des œuvres d\'art contemporain de peintres, sculpteurs et photographes professionnels.')">

    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">


    {{-- Vite : Tailwind CSS + Alpine.js --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Styles supplémentaires poussés par les vues enfants --}}
    @stack('styles')
</head>

<body class="bg-white text-[#1A1A1A] antialiased">
    @include('layouts.partials.header')
    <form method="GET" action="{{ route('catalogue.index') }}" class="p-4">
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
            <input type="number" name="annee_min" min="1900" placeholder="De" value="{{ request('annee_min') }}">
            <input type="number" name="annee_max" placeholder="À" value="{{ request('annee_max') }}">
        </div>
        <button type="submit">Rechercher</button>
    </form>
    @if($oeuvres->isEmpty())
        <p>Aucune œuvre trouvée.</p>
    @else
        <div class="masonry-grid w-full overflow-hidden" style="position: relative; margin: 0 auto;">
        
            <div class="grid-sizer" style="width: 33.333%;"></div>

            @foreach($oeuvres as $oeuvre)
                <div class="masonry-item p-3" style="width: 33.333%; float: left; box-sizing: border-box;">
                    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow">

                        <div class="w-full bg-gray-50 flex items-center justify-center min-h-[200px]">
                            <img src="https://images.unsplash.com/photo-1579783902614-a3fb3927b6a5?w=500" 
                                 class="w-full h-auto block object-contain" 
                                 loading="lazy">
                        </div>

                        <div class="p-4">
                            <h3 class="font-bold text-gray-900 text-base">{{ $oeuvre->titre }}</h3>
                            <p class="text-sm text-gray-500 mt-1">
                                {{ $oeuvre->artiste->user->prenom }} {{ $oeuvre->artiste->user->nom }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{ $oeuvres->links() }}
    @include('layouts.partials.Footer')
    <script src="https://unpkg.com/imagesloaded@5/imagesloaded.pkgd.min.js"></script>
    <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const grid = document.querySelector('.masonry-grid');

            if (grid) {
                // 1. On attend d'abord via la bibliothèque imagesLoaded que TOUTES les images soient prêtes
                imagesLoaded(grid, function() {

                    // 2. On initialise Masonry SEULEMENT quand les hauteurs réelles sont connues
                    const msnry = new Masonry(grid, {
                        itemSelector: '.masonry-item',
                        columnWidth: '.grid-sizer',
                        percentPosition: true,
                        horizontalOrder: true // Garde l'alignement de gauche à droite
                    });

                    // 3. Forcer un recalcul de sécurité pour éviter le moindre pixel de décalage
                    setTimeout(function() {
                        msnry.layout();
                    }, 200);
                });
            }
        });
    </script>
</body>
</html>
