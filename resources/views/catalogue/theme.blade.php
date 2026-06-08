@extends('layouts.app')

@section('title', 'Catalogue ' . $theme)

@section('content')
    {{--  Fil d'Ariane --}}
    <nav class="max-w-screen-xl mx-auto px-4 py-3 flex items-center gap-2 text-xs text-gray-500">
        <a href="{{ route('home') }}" class="hover:text-[#E8490F] transition-colors">Accueil</a>
        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-[#1A1A1A] font-medium first-letter:uppercase">{{ $theme }}</span>

    </nav>
    <div class="max-w-screen-xl mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">Œuvres d'art contemporain — {{ $theme }}</h1>

        @if($tiragesCorrespondants->isEmpty())
            <p class="text-gray-500">Aucune œuvre trouvée pour ce thème.</p>
        @else
            <div class="columns-2 md:columns-3 lg:columns-4 gap-4"> 
                @foreach($tiragesCorrespondants as $tirage)
                    @php
                        $oeuvre = $tirage->oeuvre;
                        $isNew = $oeuvre->created_at >= now()->subDays(30);
                        $vendue = $tirage->vendue;
                        $prix = $tirage->prix;
                        $prixAffiche = $oeuvre->taux_reduction ? round($prix * (1 - $oeuvre->taux_reduction), 2) : $prix;
                    @endphp
                    <x-carte-oeuvre
                        :oeuvre="$oeuvre"
                        :tirage="$oeuvre->tirages->first()"
                        :prix="$prix"
                        :prixAffiche="$prixAffiche"
                        :vendue="$vendue"
                        :isNew="$isNew"
                    />
                @endforeach
            </div>
        @endif
    </div>
@endsection