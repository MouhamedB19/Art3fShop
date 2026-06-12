@extends('layouts.app')
@section('title', 'Toutes nos ' . $categorie ."s")
@section('breadcrumb')
    <a href="{{ route('home') }}" class="hover:text-[#E8490F] transition-colors">Accueil</a>
    <x-mini-fleche />
    <span class="text-[#1A1A1A] font-medium first-letter:uppercase">{{ $categorie}}s</span>
@endsection

@section('content')
    
    @if($tiragesCorrespondants->isEmpty())
        <h1>Aucune œuvre trouvée pour cette catégorie.</h1>
    @else
        <div class="overflow-hidden mx-4"> 
            <h1 class="text-lg font-bold text-[#1A1A1A] my-4">Toutes les {{$categorie}}s</h1>
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
            <div class="w-full bg-zinc-900 border border-zinc-700 rounded-xl overflow-hidden flex items-center mt-4">

                <!-- Partie gauche : photo -->
                <div class="relative w-32 h-20 bg-black flex flex-col items-center justify-center shrink-0">

                    <!-- Badge -->
                    <span
                        class="absolute top-1 left-1 bg-black/80 text-white text-[10px] px-2 py-0.5 rounded-md font-semibold">
                        Artiste sponsorisé
                    </span>

                    <!-- Image -->
                    <img
                        src="https://thispersondoesnotexist.com/"
                        alt="Photo artiste"
                        class="w-full h-full object-cover"
                    >

                    
                    {{-- <span class="text-white text-sm font-bold text-center">Photo<br>artiste</span> --}}
                </div>

                <!-- Informations -->
                <div class="flex-1 px-6">
                    <h2 class="text-white font-bold text-2xl uppercase">
                        PAXAL VAN KAUFFMANN
                    </h2>

                    <p class="text-gray-400 text-sm mt-1">
                        Peintre • Mulhouse, France
                    </p>
                </div>

                <!-- Bouton -->
                <div class="pr-6">
                    <a href="#"
                       class="inline-flex items-center gap-2 bg-orange-600 hover:bg-orange-500 transition text-white font-semibold px-6 py-3 rounded-xl">
                        Découvrir
                        <x-mini-fleche/>
                    </a>
                </div>
            </div>
        </div>
    
    @endif
@endsection




    

