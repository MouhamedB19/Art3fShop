@extends('layouts.app')

@section('title', 'Récapitulatif')

@section('content')
<div class="max-w-screen-xl mx-auto px-4 py-10">

    @include('checkout.partials.etapes', ['etape' => 'resume'])

    <h1 class="text-2xl font-semibold mb-8">Récapitulatif de votre commande</h1>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="lg:col-span-2 flex flex-col gap-4">
            @foreach($tirages as $tirage)
                <div class="border border-gray-200 rounded-2xl p-5 flex gap-5 items-center">
                    <div class="w-20 h-20 rounded-xl overflow-hidden bg-gray-100 shrink-0">
                        @if($tirage->oeuvre->image)
                            <img src="{{ Storage::url($tirage->oeuvre->image) }}" class="w-full h-full object-cover">
                        @endif
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-[#1A1A1A]">{{ $tirage->oeuvre->titre }}</p>
                        <p class="text-xs text-gray-400">Tirage n°{{ $tirage->numero }}</p>
                    </div>
                    <p class="font-semibold text-[#1A1A1A]">{{ number_format($tirage->prix, 2, ',', ' ') }} €</p>
                </div>
            @endforeach
        </div>

        <div class="border border-gray-200 rounded-2xl p-6 h-fit sticky top-6">
            <h2 class="text-lg font-semibold mb-4">Total</h2>

            <div class="flex justify-between text-sm text-gray-600 mb-2">
                <span>{{ $tirages->count() }} œuvre(s)</span>
                <span>{{ number_format($total, 2, ',', ' ') }} €</span>
            </div>

            @if($coupons->isNotEmpty())
                <div class="flex justify-between text-sm text-[#E8490F] mb-2">
                    <span>Réduction ({{ $coupons->pluck('code')->join(', ') }})</span>
                    <span>-{{ number_format($reduction, 2, ',', ' ') }} €</span>
                </div>
            @endif

            <div class="border-t border-gray-100 pt-4 flex justify-between font-semibold text-[#1A1A1A] mb-6">
                <span>Total</span>
                <span>{{ number_format($total - $reduction, 2, ',', ' ') }} €</span>
            </div>

            <a href="{{ route('checkout.identification') }}"
               class="block w-full text-center bg-[#E8490F] text-white py-3 rounded-xl font-medium hover:bg-orange-700 transition-colors">
                Continuer
            </a>
        </div>
    </div>
</div>
@endsection