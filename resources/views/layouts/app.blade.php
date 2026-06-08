{{--
    ┌─────────────────────────────────────────────────────────────┐
    │  LAYOUT PRINCIPAL — art3f Shop                              │
    │  resources/views/layouts/app.blade.php                     │
    │                                                             │
    │  Utilisation dans une vue enfant :                          │
    │      @extends('layouts.app')                               │
    │      @section('title', 'Catalogue Peinture')               │
    │      @section('content') ... @endsection                   │
    └─────────────────────────────────────────────────────────────┘
--}}
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
    @livewireStyles
    {{-- Styles supplémentaires poussés par les vues enfants --}}
    @stack('styles')
</head>

<body class="bg-white text-[#1A1A1A] antialiased">

    {{-- HEADER --}}
    @include('layouts.partials.header')

    {{-- CONTENU PRINCIPAL --}}
    <main>
        @yield('content')
    </main>
    
    {{-- FOOTER --}}
    @include('layouts.partials.Footer')

    {{-- Scripts supplémentaires poussés par les vues enfants --}}
    @stack('scripts')
    @livewireScripts
</body>
</html>
