@extends('layouts.app')

@section('title', 'Mes conversations')

@section('breadcrumb')   
    <a href="{{ route('home') }}" class="hover:text-[#E8490F] transition-colors">Accueil</a>
    <x-mini-fleche/>
    <a href="{{ route('compte.index') }}" class="hover:text-[#E8490F] transition-colors">
        Mon compte
    </a>
    <x-mini-fleche/>
    <span class="text-[#1A1A1A] font-medium">Mes conversations</span>
 
@endsection

@section('content')
    <div class="max-w-screen-md mx-auto px-4 py-10">

        <h1 class="text-2xl font-semibold mb-8">Mes conversations</h1>

        @forelse($conversations as $conversation)
            @php
                $interlocuteur = Auth::id() === $conversation->client_id
                    ? $conversation->artiste
                    : $conversation->client;
                $dernierMessage = $conversation->messages->first();
                $nonLu = $conversation->messages()
                    ->where('emetteur_id', '!=', Auth::id())
                    ->whereNull('lu_a')
                    ->exists();
            @endphp

            <a href="{{ route('conversations.show', $conversation) }}"
               class="flex items-center gap-4 p-4 border border-gray-200 rounded-2xl hover:border-[#E8490F] hover:shadow-md transition-all mb-4">

                {{-- Avatar --}}
                <div class="w-12 h-12 rounded-full bg-orange-100 flex items-center justify-center shrink-0">
                    <span class="text-[#E8490F] font-semibold text-lg uppercase">
                        {{ substr($interlocuteur->name, 0, 1) }}
                    </span>
                </div>

                {{-- Contenu --}}
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between gap-2">
                        <p class="font-medium truncate">{{ $interlocuteur->name }}</p>
                        @if($dernierMessage)
                            <span class="text-xs text-gray-400 shrink-0">
                                {{ $dernierMessage->created_at->diffForHumans() }}
                            </span>
                        @endif
                    </div>
                    <p class="text-sm text-gray-500 truncate mt-0.5">
                        Commande #{{ $conversation->commande_id }}
                        @if($dernierMessage)
                            · {{ $dernierMessage->contenu }}
                        @endif
                    </p>
                </div>

                {{-- Badge non lu --}}
                @if($nonLu)
                    <span class="w-2.5 h-2.5 rounded-full bg-[#E8490F] shrink-0"></span>
                @endif

            </a>

        @empty
            <div class="text-center py-20 text-gray-400">
                <p class="text-lg">Aucune conversation pour l'instant.</p>
                <p class="text-sm mt-1">Vous pourrez contacter un artiste depuis le détail d'une commande.</p>
            </div>
        @endforelse

    </div>
@endsection