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
    <h1>Toutes les {{$categorie}}s</h1>
    <div class="masonry-grid w-full overflow-hidden">
        <div class="grid-sizer" style="width: 33.333%;"></div>

        @if($oeuvresCategorie->isEmpty())
            <p>Aucune œuvre trouvée pour cette catégorie.</p>
        @else
            @foreach($tiragesCorrespondants as $tirage)
                <x-catalogue-card-art3f 
                    artist="{{ $tirage->oeuvre->artiste->user->prenom }} {{ $tirage->oeuvre->artiste->user->nom }}" 
                    title="{{ $tirage->oeuvre->titre }}" 
                    price="{{ $tirage->prix * ($tirage->oeuvre->taux_reduction ? (1 - $tirage->oeuvre->taux_reduction) : 1) }}"
                />
            @endforeach
        @endif
    </div>
    @include('layouts.partials.Footer')

    {{-- Scripts supplémentaires poussés par les vues enfants --}}
    <script src="https://unpkg.com/imagesloaded@5/imagesloaded.pkgd.min.js"></script>
    <script src="https://unpkg.com/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var grid = document.querySelector('.masonry-grid');
        var msnry = new Masonry(grid, {
            itemSelector: '.masonry-item',
            columnWidth: '.grid-sizer',
            percentPosition: true
        });
        imagesLoaded(grid).on('progress', function() {
            msnry.layout();
        });
    });
</script>
</body>




</html>
