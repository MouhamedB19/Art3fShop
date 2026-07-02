@extends('layouts.app')
@section('title','Mes oeuvres favorites')
@section('content')
    <div class="max-w-6xl mx-auto px-4 py-8">

        <h1 class="text-2xl font-bold mb-6">Mes oeuvres favorites</h1>

        @if(session('success'))
            <div class="mb-4 p-3 rounded bg-green-100 text-green-800 text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-3 rounded bg-red-100 text-red-800 text-sm">
                {{ session('error') }}
            </div>
        @endif

        <p class="text-sm text-gray-500 mb-6">{{ $tirages->count() }} / 5 oeuvres favorites</p>

        @if($tirages->isEmpty())
            <div class="text-center py-16 text-gray-500">
                <p class="mb-4">Tu n'as encore aucune oeuvre favorite.</p>
                <a href="{{ route('oeuvres.index') }}" class="inline-block px-4 py-2 rounded text-white"
                    style="background-color:#E8490F">
                    Parcourir le catalogue
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach($tirages as $tirage)
                    
                    @php
                        $oeuvre = $tirage->oeuvre;
                        $vendue = $tirage->status === 'vendu';
                        $prix = $tirage->prix;
                        $prixAffiche = $oeuvre->taux_reduction
                            ? round($prix * (1 - $oeuvre->taux_reduction), 2)
                            : $prix;
                    @endphp
    
                    <x-carte-oeuvre
                        :oeuvre="$oeuvre"
                        :tirage="$tirage"
                        :vendue="$vendue"
                        :isNew="false"
                        :prix="$prix"
                        :prixAffiche="$prixAffiche"
                        routeFavoris="{{route('compte.favoris.oeuvres.handle',$tirage->id)}}"
                    />
                
                @endforeach
            </div>
        @endif

    </div>
@endsection