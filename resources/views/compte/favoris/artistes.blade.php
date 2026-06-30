@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto px-4 py-8">

        <h1 class="text-2xl font-bold mb-6">Mes artistes favoris</h1>

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

        <p class="text-sm text-gray-500 mb-6">{{ $artistes->count() }} / 3 artistes suivis</p>

        @if($artistes->isEmpty())
            <div class="text-center py-16 text-gray-500">
                <p class="mb-4">Tu ne suis encore aucun artiste.</p>
                <a href="{{ route('artistes.index') }}" class="inline-block px-4 py-2 rounded text-white"
                    style="background-color:#E8490F">
                    Découvrir des artistes
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @foreach($artistes as $artiste)
                    @php
                        $nomArtiste = $artiste->nom_d_artiste ?: ($artiste->user->nom . ' ' . $artiste->user->prenom);
                    @endphp
                    <div class="border rounded-lg overflow-hidden text-center p-6 relative">

                        <form action="{{ route('compte.favoris.artistes.handle', $artiste->id) }}" method="POST"
                            class="absolute top-2 right-2">
                            @csrf
                            <button type="submit" title="Ne plus suivre"
                                class="w-9 h-9 flex items-center justify-center rounded-full bg-white shadow hover:bg-red-50">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#E8490F" class="w-5 h-5">
                                    <path
                                        d="M12 21s-6.716-4.35-9.428-8.293C.81 9.74 1.2 6.5 3.6 4.8c2.1-1.5 4.9-1.05 6.4 1.05L12 7.5l2-1.65c1.5-2.1 4.3-2.55 6.4-1.05 2.4 1.7 2.79 4.94 1.03 7.907C18.716 16.65 12 21 12 21z" />
                                </svg>
                            </button>
                        </form>

                        <a href="{{ route('artistes.show', $artiste->id) }}">
                            <div class="w-24 h-24 mx-auto rounded-full overflow-hidden bg-gray-100 mb-4">
                                @if($artiste->photo)
                                    <img src="{{ asset('storage/' . $artiste->photo) }}" alt="{{ $nomArtiste }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400 text-2xl font-bold">
                                        {{ strtoupper(substr($nomArtiste, 0, 1)) }}
                                    </div>
                                @endif
                            </div>

                            <h2 class="font-semibold text-gray-900">{{ $nomArtiste }}</h2>

                            @if($artiste->a_la_une)
                                <span class="inline-block mt-2 text-xs px-2 py-1 rounded"
                                    style="background-color:#E8490F22;color:#E8490F">
                                    Artiste à la une
                                </span>
                            @endif

                            @if($artiste->bio)
                                <p class="text-sm text-gray-500 mt-2 line-clamp-2">{{ $artiste->bio }}</p>
                            @endif
                        </a>
                    </div>
                @endforeach
            </div>
        @endif

    </div>
@endsection