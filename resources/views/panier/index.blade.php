@extends('layouts.app')

@section('title', 'Mon panier')

@section('breadcrumb')
    <a href="{{ route('home') }}" class="hover:text-[#E8490F] transition-colors">Accueil</a>
    <x-mini-fleche />
    <span class="text-[#1A1A1A]">Mon panier</span>
@endsection

@section('content')
    <div class="max-w-screen-xl mx-auto px-4 py-10">

        <h1 class="text-2xl font-semibold mb-8">Mon panier</h1>

        @if($tirages->isEmpty())
            {{-- Panier vide --}}
            <div class="flex flex-col items-center justify-center py-24 text-center">
                <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993
                               1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0
                               01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576
                               0 1.059.435 1.119 1.007z" />
                </svg>
                <p class="text-gray-500 text-lg mb-2">Votre panier est vide</p>
                <p class="text-gray-400 text-sm mb-6">Découvrez nos œuvres et ajoutez-en à votre panier.</p>
                <a href="{{ route('catalogue.index') }}"
                    class="bg-[#E8490F] text-white px-6 py-2.5 rounded-xl text-sm font-medium hover:bg-orange-700 transition-colors">
                    Parcourir le catalogue
                </a>
            </div>

        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Liste des tirages --}}
                <div class="lg:col-span-2 flex flex-col gap-4">
                    @foreach($tirages as $tirage)
                        <div
                            class="border border-gray-200 rounded-2xl p-5 flex gap-5 items-start hover:border-[#E8490F] transition-all">

                            {{-- Image de l'œuvre --}}
                            <div class="w-24 h-24 rounded-xl overflow-hidden bg-gray-100 shrink-0">
                                @if($tirage->oeuvre->photo_principale)
                                    <img src="{{ Storage::url($tirage->oeuvre->photo_principale) }}" alt="{{ $tirage->oeuvre->titre }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 18h16.5" />
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            {{-- Infos --}}
                            <div class="flex-1">
                                <p class="font-medium text-[#1A1A1A]">{{ $tirage->oeuvre->titre }}</p>
                                <p class="text-sm text-gray-500 mb-1">
                                    par
                                    @if($tirage->oeuvre->artiste->nom_d_artiste)
                                        {{ $tirage->oeuvre->artiste->nom_d_artiste }}
                                    @else
                                        {{ $tirage->oeuvre->artiste->user->nom }} {{ $tirage->oeuvre->artiste->user->prenom }}
                                    @endif
                                </p>
                                <p class="text-xs text-gray-400">
                                    Tirage n°{{ $tirage->numero }}
                                    @if($tirage->encadrement)
                                        · Avec encadrement
                                    @endif
                                </p>
                            </div>

                            {{-- Prix + Supprimer --}}
                            <div class="flex flex-col items-end justify-between h-full gap-4">
                                <p class="font-semibold text-[#1A1A1A]">
                                    @if($tirage->oeuvre->taux_reduction)
                                        {{ number_format($tirage->prix * (1 - $tirage->oeuvre->taux_reduction), 2, ',', ' ') }} €
                                    @else
                                        {{ number_format($tirage->prix,2,',',' ') }} €
                                    @endif
                                </p>
                                <form action="{{ route('panier.remove', $tirage) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-xs text-gray-400 hover:text-[#E8490F] transition-colors underline underline-offset-2">
                                        Retirer
                                    </button>
                                </form>
                            </div>

                        </div>
                    @endforeach

                    {{-- Vider le panier --}}
                    <form action="{{ route('panier.clear') }}" method="POST" class="mt-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="text-sm text-gray-400 hover:text-[#E8490F] transition-colors underline underline-offset-2">
                            Vider le panier
                        </button>
                    </form>
                </div>

                {{-- Récapitulatif --}}
                <div class="border border-gray-200 rounded-2xl p-6 h-fit sticky top-6">
                    <h2 class="text-lg font-semibold mb-4">Récapitulatif</h2>

                    <div class="flex justify-between text-sm text-gray-600 mb-2">
                        <span>{{ $tirages->count() }} œuvre(s)</span>
                        <span>{{ number_format($total, 2, ',', ' ') }} €</span>
                    </div>

                    <div class="flex justify-between text-sm text-gray-400 mb-6">
                        <span>Livraison</span>
                        <span>calculée à la commande</span>
                    </div>

                    {{-- Coupon --}}
                    <div class="border-t border-gray-100 pt-4 mb-4">
                        
                        @if($coupons->isNotEmpty())
                            @foreach($coupons as $coupon)
                                <div class="flex items-center justify-between bg-orange-50 rounded-xl px-3 py-2.5 mb-1">
                                    <div class="flex items-center gap-1.5">
                                        <svg class="w-4 h-4 text-[#E8490F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span class="text-sm font-medium text-[#1A1A1A]">{{ $coupon->code }}</span>
                                    </div>
                                    <form action="{{ route('coupon.retirer', $coupon) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs text-gray-400 hover:text-[#E8490F] underline underline-offset-2">
                                            Retirer
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        
                            
                        @endif
                        <form action="{{ route('coupon.check') }}" method="POST" class="flex gap-2">
                            @csrf
                            <input type="text" name="code" placeholder="Code promo" value="{{ old('code') }}" class="flex-1 rounded-xl border border-gray-200 px-3 py-2 text-sm
                                               focus:outline-none focus:ring-1 focus:ring-[#E8490F] focus:border-[#E8490F]">
                            <button type="submit" class="text-sm font-medium text-[#E8490F] border border-[#E8490F] px-4 py-2 rounded-xl
                                               hover:bg-orange-50 transition-colors">
                                OK
                            </button>
                        </form>
                        @error('code')
                            <p class="text-xs text-red-500 mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="border-t border-gray-100 pt-4 flex justify-between font-semibold text-[#1A1A1A] mb-6">
                        <span>Total</span>
                        <span>{{ number_format($totalFinal ?? $total, 2, ',', ' ') }} €</span>
                    </div>

                    <a href="{{ route('checkout.resume') }}"
                        class="block w-full text-center bg-[#E8490F] text-white py-3 rounded-xl font-medium hover:bg-orange-700 transition-colors">
                        Passer la commande
                    </a>
                </div>
            </div>
        @endif

    </div>
@endsection