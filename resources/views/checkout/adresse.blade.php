{{-- resources/views/checkout/adresse.blade.php --}}
@extends('layouts.app')

@section('title', 'Adresse de livraison')

@section('content')
    <div class="max-w-screen-xl mx-auto px-4 py-10">

        @include('checkout.partials.etapes', ['etape' => 'adresse'])

        <div class="max-w-md mx-auto border border-gray-200 rounded-2xl p-6">
            <h1 class="text-xl font-semibold mb-6">Adresse de livraison</h1>

            <form action="{{ route('checkout.adresse.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label class="text-sm text-gray-600">Adresse</label>
                    <input type="text" name="adresse" value="{{ old('adresse') }}" required
                        class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm mt-1 focus:outline-none focus:ring-1 focus:ring-[#E8490F]">
                    @error('adresse')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="text-sm text-gray-600">Code postal</label>
                    <input type="text" name="code_postal" value="{{ old('code_postal') }}" required
                        class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm mt-1 focus:outline-none focus:ring-1 focus:ring-[#E8490F]">
                    @error('code_postal')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="text-sm text-gray-600">Pays</label>
                    <select name="pays_id" id="pays_id" required class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm mt-1">
                        <option value="">Sélectionner...</option>
                        @foreach($pays as $p)
                            <option value="{{ $p->id }}" @selected(old('pays_id') == $p->id)>{{ $p->nom_pays }}</option>
                        @endforeach
                    </select>
                    @error('pays_id')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="text-sm text-gray-600">Ville</label>
                    <select name="ville_id" id="ville_id" required
                        class="w-full rounded-xl border border-gray-200 px-3 py-2 text-sm mt-1">
                        <option value="">Sélectionner d'abord un pays...</option>
                        
                    </select>
                    @error('ville_id')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                </div>

                <button type="submit"
                    class="block w-full text-center bg-[#E8490F] text-white py-3 rounded-xl font-medium hover:bg-orange-700 transition-colors mt-2">
                    Continuer
                </button>
            </form>
        </div>
    </div>
    <script>
        document.getElementById('pays_id').addEventListener('change', function() {
            const pays_id = this.value;
            const villeSelect = document.getElementById('ville_id');

            villeSelect.innerHTML = '<option value="">Chargement...</option>';

            fetch(`/villes/${pays_id}`)
                .then(response => response.json())
                .then(villes => {
                    villeSelect.innerHTML = '<option value="">-- Choisir une ville --</option>';
                    villes.forEach(ville => {
                        villeSelect.innerHTML += `<option value="${ville.id}">${ville.nom_ville}</option>`;
                    });
            });
        });
    </script>
@endsection