@extends('layouts.app')

@section('title', 'Livraison')

@section('content')
    <div class="max-w-screen-xl mx-auto px-4 py-10">

        @include('checkout.partials.etapes', ['etape' => 'livraison'])

        <div class="max-w-md mx-auto border border-gray-200 rounded-2xl p-6">
            <h1 class="text-xl font-semibold mb-6">Mode de livraison</h1>

            @if($fraisOfferts)
                <div class="bg-orange-50 rounded-xl p-4 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#E8490F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <p class="text-sm text-[#1A1A1A]">Livraison offerte pour {{ $pays->nom_pays }}</p>
                </div>
            @else
                <div class="bg-gray-50 rounded-xl p-4 mb-6">
                    <p class="text-sm text-gray-600">Des frais de livraison s'appliquent hors UE.</p>
                </div>
            @endif

            <div x-data="{ cadeau: false }" class="border-t border-gray-100 pt-4 mb-6">
                <label class="flex items-center gap-2 text-sm text-[#1A1A1A]">
                    <input type="checkbox" x-model="cadeau" form="form-livraison" name="est_cadeau"
                        class="rounded text-[#E8490F]">
                    C'est un cadeau ?
                </label>
                <div x-show="cadeau" x-transition class="mt-2">
                    <textarea form="form-livraison" name="message_cadeau" maxlength="300" rows="3"
                        placeholder="Votre message..."
                        class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#E8490F]"></textarea>
                </div>
            </div>

            <form id="form-livraison" action="{{ route('checkout.livraison.store') }}" method="POST">
                @csrf
                <button type="submit"
                    class="block w-full text-center bg-[#E8490F] text-white py-3 rounded-xl font-medium hover:bg-orange-700 transition-colors">
                    Continuer
                </button>
            </form>
        </div>
    </div>
@endsection