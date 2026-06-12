@extends('layouts.app')

@section('title', 'Catalogue ' . $theme)


{{--  Fil d'Ariane --}}
@section('breadcrumb')
        <a href="{{ route('home') }}" class="hover:text-[#E8490F] transition-colors">Accueil</a>
        <x-mini-fleche />
        <a href="{{ route('catalogue.index') }}" class="hover:text-[#E8490F] transition-colors">
            Catalogue
        </a>
        <x-mini-fleche/>
        <span class="text-[#1A1A1A] font-medium first-letter:uppercase">{{ $theme }}</span>
@endsection

@section('content')
    
    
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