@extends('layouts.app')

@section('title', $tirage->oeuvre->titre)

@section('content')
    <div class="max-w-screen-xl mx-auto px-4 py-12 flex justify-center">
        <div>
            <img src="{{ asset('images/oeuvres/' . $tirage->oeuvre->photo_principale) }}" alt="{{ $tirage->oeuvre->titre }}" class="w-full h-full object-cover">
        </div>
        <div>
            <h1 class="text-3xl font-black">{{ $tirage->prix }} €</h1>
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-uppercase mt-4">
                Ajouter au panier
            </button>
            <span>Frais de livraison offerts </span>
            @if($tirage->oeuvre->artiste->nom_d_artiste)
                <p class="text-sm text-gray-500 mt-2">{{ $tirage->oeuvre->artiste->nom_d_artiste }}</p>
            @else
                <p class="text-sm text-gray-500 mt-2">{{ $tirage->oeuvre->artiste->user->nom }}{{ $tirage->oeuvre->artiste->user->prenom }}</p>
            @endif
            <span> {{ $tirage->oeuvre->titre}}</span>
            <span> {{ $tirage->oeuvre->annee_de_creation }}</span>
        </div>
        <h2 class="text-2xl font-bold mt-8 text-uppercase">Infos pratiques</h2>
        <ul>
            <li class="flex justify-between">
                <span class="font-bold">Technique</span>
                <span>{{ $tirage->oeuvre->categorie->nom_technique }}</span>
            </li>
            <li class="flex justify-between">
                <span class="font-bold">Dimensions</span>
                <span>{{ $tirage->dimensions->largeur }} x {{ $tirage->dimensions->hauteur }} cm</span>
            </li>
            <li class="flex justify-between">
                <span class="font-bold">Supports</span>
                <span>{{ $tirage->oeuvre->support->nom_support }}</span>
            </li>
        </ul>

    </div>
@endsection