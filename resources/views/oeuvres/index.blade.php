@extends('layouts.app')
@section('title',"Mes oeuvres")

@section('content')
    <div>
        <h1>Oeuvres</h1>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @else
            <h2>Bienvenue dans votre musée personnel, 
                @if(Auth::user()->artiste->nom_d_artiste)
                    {{ Auth::user()->artiste->nom_d_artiste }}
                @else
                    {{ Auth::user()->prenom }} {{ Auth::user()->nom }}!</h2>
                @endif
        @endif
        <h3>Mes oeuvres</h3>
        <ul>
            @foreach($oeuvres as $oeuvre)
                <li>
                    <span>{{ $oeuvre->titre }}</span>
                    <a href="{{ route('oeuvres.edit', $oeuvre) }}">Modifier</a>
                    <img src="{{ asset('storage/' . $oeuvre->photo_principale) }}" alt="{{ $oeuvre->titre }}" width="100">
                    <form method="POST" action="{{ route('oeuvres.destroy', $oeuvre) }}" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette oeuvre ?')">Supprimer</button>
                    </form>
                </li>
            @endforeach
        </ul>
        <a href="{{ route('oeuvres.create') }}">Ajouter une oeuvre</a>
        <a href="{{ route('dashboard') }}">Retour au tableau de bord</a>
    </div>
@endsection