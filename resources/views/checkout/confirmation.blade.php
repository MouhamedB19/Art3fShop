@extends('layouts.app')

@section('title', 'Commande confirmée')

@section('content')
    <div class="max-w-screen-xl mx-auto px-4 py-16">
        <div class="max-w-md mx-auto text-center">
            <div class="w-16 h-16 rounded-full bg-orange-50 flex items-center justify-center mx-auto mb-6">
                <svg class="w-8 h-8 text-[#E8490F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>

            <h1 class="text-2xl font-semibold mb-2">Commande confirmée !</h1>
            <p class="text-gray-500 mb-8">Votre commande n°{{ $commande->id }} a bien été enregistrée.</p>

            @if($commande->est_cadeau)
                <div class="bg-orange-50 rounded-xl p-4 mb-6 text-left">
                    <p class="text-xs text-gray-500 mb-1">Message cadeau</p>
                    <p class="text-sm text-[#1A1A1A]">{{ $commande->message_cadeau }}</p>
                </div>
            @endif

            <a href="{{ route('home') }}"
                class="inline-block bg-[#E8490F] text-white px-6 py-2.5 rounded-xl text-sm font-medium hover:bg-orange-700 transition-colors">
                Retour à l'accueil
            </a>
        </div>
    </div>
@endsection