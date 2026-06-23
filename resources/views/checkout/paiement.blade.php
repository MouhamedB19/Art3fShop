@extends('layouts.app')

@section('title', 'Paiement')

@section('content')
    <div class="max-w-screen-xl mx-auto px-4 py-10">

        @include('checkout.partials.etapes', ['etape' => 'paiement'])

        <div class="max-w-md mx-auto border border-gray-200 rounded-2xl p-6">
            <h1 class="text-xl font-semibold mb-6">Paiement</h1>

            <div class="bg-gray-50 rounded-xl p-4 mb-6 flex justify-between font-semibold text-[#1A1A1A]">
                <span>Total à payer</span>
                <span>{{ number_format($totalFinal, 2, ',', ' ') }} €</span>
            </div>

            <form action="{{ route('checkout.paiement.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="text-sm text-gray-600">Numéro de carte</label>
                    <input type="text" name="numero_carte" placeholder="4242 4242 4242 4242" required
                        class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm mt-1 focus:outline-none focus:ring-1 focus:ring-[#E8490F]">
                    @error('numero_carte')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="flex gap-3">
                    <div class="flex-1">
                        <label class="text-sm text-gray-600">Expiration</label>
                        <input type="text" name="date_expiration" placeholder="MM/AA" required
                            class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm mt-1 focus:outline-none focus:ring-1 focus:ring-[#E8490F]">
                        @error('date_expiration')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div class="flex-1">
                        <label class="text-sm text-gray-600">CVC</label>
                        <input type="text" name="cvc" placeholder="123" required
                            class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm mt-1 focus:outline-none focus:ring-1 focus:ring-[#E8490F]">
                        @error('cvc')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <button type="submit"
                    class="block w-full text-center bg-[#E8490F] text-white py-3 rounded-xl font-medium hover:bg-orange-700 transition-colors mt-2">
                    Payer {{ number_format($totalFinal, 2, ',', ' ') }} €
                </button>
            </form>
        </div>
    </div>
@endsection