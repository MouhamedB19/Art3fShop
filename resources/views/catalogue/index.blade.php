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
        <div class="flex justify-center">
            <input  class="rounded-lg w-1/2" type="text" name="recherche" 
                   placeholder="Artiste, œuvre..." 
                   value="{{ request('recherche') }}">
        </div>
        <div class='flex gap-4 flex-wrap justify-center my-4'>
            <select name="categorie_id" class="rounded-lg">
                <option value="">Toutes les catégories</option>
                @foreach($categories as $categorie)
                    <option value="{{ $categorie->id }}" {{ request('categorie_id') == $categorie->id ? 'selected' : '' }}>
                        {{ $categorie->nom_categorie }}
                    </option>
                @endforeach
            </select>

            <select name="theme_id" class="rounded-lg">
                <option value="">Tous les thèmes</option>
                @foreach($themes as $theme)
                    <option value="{{ $theme->id }}" {{ request('theme_id') == $theme->id ? 'selected' : '' }}>
                        {{ $theme->nom_theme }}
                    </option>
                @endforeach
            </select>
            <select name="couleur_id" class="rounded-lg">
                <option value="">Toutes les couleurs</option>
                @foreach($couleurs as $couleur)
                    <option value="{{ $couleur->id }}" {{ request('couleur_id') == $couleur->id ? 'selected' : '' }}>
                        {{ $couleur->nom_couleur }}
                    </option>
                @endforeach
            </select>
            <select name="orientation" class="rounded-lg">
                <option value="">Toutes les orientations</option>
                <option value="portrait" {{ request('orientation') == 'portrait' ? 'selected' : '' }}>Portrait</option>
                <option value="paysage" {{ request('orientation') == 'paysage' ? 'selected' : '' }}>Paysage</option>
                <option value="carre" {{ request('orientation') == 'carre' ? 'selected' : '' }}>Carré</option>
            </select>
        </div>
        <div class="flex gap-4 justify-center align-center">
            <label>Année</label>
            <input type="number" class="rounded-lg" name="annee_min" min="1900" placeholder="De" value="{{ request('annee_min') }}">
            <input type="number" class="rounded-lg" name="annee_max" placeholder="À" value="{{ request('annee_max') }}">
        </div>
        <div class="flex gap-4 justify-center align-center my-4">
            <button type="submit"class="px-5 py-2.5 bg-[#E8490F] hover:bg-orange-600 text-white text-sm        font-bold rounded-lg transition-colors disabled:opacity-60 shrink-0        flex items-center gap-2">
                Rechercher
            </button>
        </div>
    </form>
    @if($oeuvres->isEmpty())
        <p>Aucune œuvre trouvée.</p>
    @else
        <div class="masonry-grid w-full overflow-hidden" style="position: relative; margin: 0 auto;">
        
            <div class="grid-sizer" style="width: 33.333%;"></div>

            @foreach($oeuvres as $oeuvre)
                <x-catalogue-card-art3f artist="{{ $oeuvre->artiste->user->prenom }} {{ $oeuvre->artiste->user->nom }}" title="{{ $oeuvre->titre }}" />
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
