@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4">
    <div class="max-w-4xl mx-auto">

        {{-- Header --}}
        <div class="mb-8">
            <a href="{{ route('oeuvres.index') }}"
               class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-800 mb-4 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Mes œuvres
            </a>
            <h1 class="text-2xl font-semibold text-gray-900">Ajouter une œuvre</h1>
            <p class="text-sm text-gray-500 mt-1">Les champs marqués <span class="text-[#E8490F]">*</span> sont obligatoires.</p>
        </div>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('oeuvres.store') }}" method="POST" enctype="multipart/form-data"
              x-data="oeuvreForm()" class="space-y-6">
            @csrf

            {{-- ─── BLOC 1 : Informations générales ─── --}}
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="text-base font-medium text-gray-900">Informations générales</h2>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">

                    <div class="md:col-span-2">
                        <label class="block text-sm text-gray-700 mb-1.5">Titre <span class="text-[#E8490F]">*</span></label>
                        <input type="text" name="titre" value="{{ old('titre') }}"
                               class="w-full rounded-lg border border-gray-200 px-3.5 py-2.5 text-sm focus:outline-none focus:border-[#E8490F] focus:ring-1 focus:ring-[#E8490F] transition"
                               placeholder="Ex : Lumières d'automne" required>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 mb-1.5">Année de création <span class="text-[#E8490F]">*</span></label>
                        <input type="number" name="annee_de_creation" value="{{ old('annee_de_creation', date('Y')) }}"
                               min="1900" max="{{ date('Y') }}"
                               class="w-full rounded-lg border border-gray-200 px-3.5 py-2.5 text-sm focus:outline-none focus:border-[#E8490F] focus:ring-1 focus:ring-[#E8490F] transition"
                               required>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 mb-1.5">Orientation <span class="text-[#E8490F]">*</span></label>
                        <select name="orientation"
                                class="w-full rounded-lg border border-gray-200 px-3.5 py-2.5 text-sm focus:outline-none focus:border-[#E8490F] focus:ring-1 focus:ring-[#E8490F] transition bg-white" required>
                            <option value="">Choisir…</option>
                            <option value="portrait"  {{ old('orientation') == 'portrait'  ? 'selected' : '' }}>Portrait</option>
                            <option value="paysage"   {{ old('orientation') == 'paysage'   ? 'selected' : '' }}>Paysage</option>
                            <option value="carre"     {{ old('orientation') == 'carre'     ? 'selected' : '' }}>Carré</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 mb-1.5">Catégorie <span class="text-[#E8490F]">*</span></label>
                        <select name="categorie_id"
                                class="w-full rounded-lg border border-gray-200 px-3.5 py-2.5 text-sm focus:outline-none focus:border-[#E8490F] focus:ring-1 focus:ring-[#E8490F] transition bg-white" required>
                            <option value="">Choisir…</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('categorie_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->nom_categorie }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 mb-1.5">Support <span class="text-[#E8490F]">*</span></label>
                        <select name="support_id"
                                class="w-full rounded-lg border border-gray-200 px-3.5 py-2.5 text-sm focus:outline-none focus:border-[#E8490F] focus:ring-1 focus:ring-[#E8490F] transition bg-white" required>
                            <option value="">Choisir…</option>
                            @foreach($supports as $support)
                                <option value="{{ $support->id }}" {{ old('support_id') == $support->id ? 'selected' : '' }}>
                                    {{ $support->nom_support }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 mb-1.5">Taux de réduction <span class="text-gray-400 font-normal">(optionnel)</span></label>
                        <div class="relative">
                            <input type="number" name="taux_reduction" value="{{ old('taux_reduction') }}"
                                   min="0" max="0.99" step="0.01"
                                   class="w-full rounded-lg border border-gray-200 px-3.5 py-2.5 pr-8 text-sm focus:outline-none focus:border-[#E8490F] focus:ring-1 focus:ring-[#E8490F] transition"
                                   placeholder="0.15">
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">%</span>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Entre 0 et 0.99 (ex: 0.15 = 15%)</p>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm text-gray-700 mb-1.5">Description <span class="text-[#E8490F]">*</span></label>
                        <textarea name="description" rows="3"
                                  class="w-full rounded-lg border border-gray-200 px-3.5 py-2.5 text-sm focus:outline-none focus:border-[#E8490F] focus:ring-1 focus:ring-[#E8490F] transition resize-none"
                                  placeholder="Décrivez votre œuvre, sa genèse, ses inspirations…" required>{{ old('description') }}</textarea>
                    </div>

                    <div class="flex items-center gap-3">
                        <input type="hidden" name="visible" value="0">
                        <input type="checkbox" name="visible" id="visible" value="1"
                               {{ old('visible', 1) ? 'checked' : '' }}
                               class="w-4 h-4 rounded border-gray-300 accent-[#E8490F]">
                        <label for="visible" class="text-sm text-gray-700">Visible dans le catalogue</label>
                    </div>

                </div>
            </div>

            {{-- ─── BLOC 2 : Photo principale ─── --}}
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="text-base font-medium text-gray-900">Photo principale <span class="text-[#E8490F]">*</span></h2>
                </div>
                <div class="p-6">
                    <label class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-gray-200 rounded-xl cursor-pointer hover:border-[#E8490F] hover:bg-orange-50 transition group"
                           x-on:dragover.prevent x-on:drop.prevent="handleDrop($event)">
                        <template x-if="!previewUrl">
                            <div class="text-center">
                                <svg class="w-8 h-8 text-gray-300 mx-auto mb-2 group-hover:text-[#E8490F] transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4-4m0 0l4 4m-4-4v8M4 8V6a2 2 0 012-2h12a2 2 0 012 2v2M16 12l4-4m0 0l-4-4m4 4H8"/>
                                </svg>
                                <p class="text-sm text-gray-500">Glisser-déposer ou <span class="text-[#E8490F]">parcourir</span></p>
                                <p class="text-xs text-gray-400 mt-1">JPG, PNG, TIFF — min 600×600px — max 10 Mo</p>
                            </div>
                        </template>
                        <template x-if="previewUrl">
                            <img :src="previewUrl" class="h-full w-full object-contain rounded-lg">
                        </template>
                        <input type="file" name="photo_principale" accept="image/jpeg,image/png,image/tiff"
                               class="hidden" required
                               x-on:change="handleFile($event.target.files[0])">
                    </label>
                </div>
            </div>

            {{-- ─── BLOC 3 : Thèmes & Couleurs ─── --}}
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="text-base font-medium text-gray-900">Thèmes & Couleurs</h2>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm text-gray-700 mb-2">Thèmes</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach($themes as $theme)
                                <label class="cursor-pointer">
                                    <input type="checkbox" name="themes[]" value="{{ $theme->id }}"
                                           {{ in_array($theme->id, old('themes', [])) ? 'checked' : '' }}
                                           class="hidden peer">
                                    <span class="inline-block px-3 py-1.5 rounded-full text-xs border border-gray-200 text-gray-600
                                                 peer-checked:bg-[#E8490F] peer-checked:border-[#E8490F] peer-checked:text-white transition">
                                        {{ $theme->nom_theme }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-700 mb-2">Couleurs dominantes</label>
                        <div class="flex flex-wrap gap-2">
                            @foreach($couleurs as $couleur)
                                <label class="cursor-pointer">
                                    <input type="checkbox" name="couleurs[]" value="{{ $couleur->id }}"
                                           {{ in_array($couleur->id, old('couleurs', [])) ? 'checked' : '' }}
                                           class="hidden peer">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs border border-gray-200 text-gray-600
                                                 peer-checked:border-[#E8490F] peer-checked:text-[#E8490F] transition">
                                        @if($couleur->hex)
                                            <span class="w-3 h-3 rounded-full border border-gray-200 inline-block"
                                                  style="background-color: {{ $couleur->hex }}"></span>
                                        @endif
                                        {{ $couleur->nom_couleur }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- ─── BLOC 4 : Tirages ─── --}}
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <h2 class="text-base font-medium text-gray-900">Tirages <span class="text-[#E8490F]">*</span></h2>
                        <p class="text-xs text-gray-400 mt-0.5">Chaque tirage est un exemplaire mis en vente.</p>
                    </div>
                    <button type="button" x-on:click="addTirage()"
                            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg border border-[#E8490F] text-[#E8490F] text-sm hover:bg-orange-50 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Ajouter un tirage
                    </button>
                </div>

                <div class="divide-y divide-gray-100">
                    <template x-for="(tirage, index) in tirages" :key="tirage.id">
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-sm font-medium text-gray-700" x-text="'Tirage #' + (index + 1)"></span>
                                <button type="button" x-show="tirages.length > 1" x-on:click="removeTirage(index)"
                                        class="text-xs text-gray-400 hover:text-red-500 transition flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M8 7V4h8v3"/>
                                    </svg>
                                    Supprimer
                                </button>
                            </div>

                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-xs text-gray-500 mb-1.5">N° de tirage <span class="text-[#E8490F]">*</span></label>
                                    <input type="number" :name="'tirages[' + index + '][numero]'" x-model="tirage.numero"
                                           min="1" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:border-[#E8490F] focus:ring-1 focus:ring-[#E8490F] transition" required>
                                </div>

                                <div>
                                    <label class="block text-xs text-gray-500 mb-1.5">Prix (€) <span class="text-[#E8490F]">*</span></label>
                                    <input type="number" :name="'tirages[' + index + '][prix]'" x-model="tirage.prix"
                                           min="0" step="0.01" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:border-[#E8490F] focus:ring-1 focus:ring-[#E8490F] transition" required>
                                </div>

                                <div>
                                    <label class="block text-xs text-gray-500 mb-1.5">Statut <span class="text-[#E8490F]">*</span></label>
                                    <select :name="'tirages[' + index + '][status]'" x-model="tirage.status"
                                            class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:border-[#E8490F] focus:ring-1 focus:ring-[#E8490F] transition bg-white" required>
                                        <option value="disponible">Disponible</option>
                                        <option value="vendu">Vendu</option>
                                        <option value="reserve">Réservé</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs text-gray-500 mb-1.5">Largeur (cm) <span class="text-[#E8490F]">*</span></label>
                                    <input type="number" :name="'tirages[' + index + '][largeur]'" x-model="tirage.largeur"
                                           min="1" step="0.5" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:border-[#E8490F] focus:ring-1 focus:ring-[#E8490F] transition" required>
                                </div>

                                <div>
                                    <label class="block text-xs text-gray-500 mb-1.5">Hauteur (cm) <span class="text-[#E8490F]">*</span></label>
                                    <input type="number" :name="'tirages[' + index + '][hauteur]'" x-model="tirage.hauteur"
                                           min="1" step="0.5" class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:border-[#E8490F] focus:ring-1 focus:ring-[#E8490F] transition" required>
                                </div>

                                <div>
                                    <label class="block text-xs text-gray-500 mb-1.5">Encadrement</label>
                                    <select :name="'tirages[' + index + '][encadrement]'" x-model="tirage.encadrement"
                                            class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:border-[#E8490F] focus:ring-1 focus:ring-[#E8490F] transition bg-white">
                                        <option value="0">Sans cadre</option>
                                        <option value="1">Avec cadre</option>
                                    </select>
                                </div>

                                <div class="flex items-center gap-2 col-span-2 md:col-span-1">
                                    <input type="hidden" :name="'tirages[' + index + '][pret_a_accrocher]'" value="0">
                                    
                                    <x-checkbox
                                        model="tirage.pret_a_accrocher"
                                        name-base="tirages"
                                        field="pret_a_accrocher"
                                        id-prefix="cadre"
                                    />
                                    <label :for="'pret_' + index" class="text-xs text-gray-600">Prêt à accrocher</label>
                                </div>

                                <div class="flex items-center gap-2 col-span-2 md:col-span-1">
                                    <input type="hidden" :name="'tirages[' + index + '][avec_cadre]'" value="0">
                                    <x-checkbox model="tirage.avec_cadre" name-base="tirages" field="avec_cadre" id-prefix="cadre"/>
                                    <label :for="'cadre_' + index" class="text-xs text-gray-600">Vendu avec cadre</label>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            {{-- ─── Actions ─── --}}
            <div class="flex items-center justify-end gap-3 pb-8">
                <a href="{{ route('oeuvres.index') }}"
                   class="px-5 py-2.5 rounded-lg border border-gray-200 text-sm text-gray-700 hover:bg-gray-50 transition">
                    Annuler
                </a>
                <form action="{{ route('oeuvres.index') }}" method="GET">
                    <button type="submit"
                            class="px-6 py-2.5 rounded-lg bg-[#E8490F] text-white text-sm font-medium hover:bg-[#c93d0c] transition">
                        Publier l'œuvre
                    </button>
                </form>
            </div>

        </form>
    </div>
</div>

@push('scripts')
<script>
function oeuvreForm() {
    return {
        previewUrl: null,
        tirages: [{ id: Date.now(), numero: 1, prix: '', status: 'disponible', largeur: '', hauteur: '', encadrement: 'sans', pret_a_accrocher: false, avec_cadre: false }],

        handleFile(file) {
            if (!file) return;
            const reader = new FileReader();
            reader.onload = e => this.previewUrl = e.target.result;
            reader.readAsDataURL(file);
        },

        handleDrop(event) {
            const file = event.dataTransfer.files[0];
            if (file) {
                this.handleFile(file);
                // Injecter dans l'input file via DataTransfer
                const input = event.currentTarget.querySelector('input[type="file"]');
                const dt = new DataTransfer();
                dt.items.add(file);
                input.files = dt.files;
            }
        },

        addTirage() {
            const last = this.tirages[this.tirages.length - 1];
            this.tirages.push({
                id: Date.now(),
                numero: last.numero + 1,
                prix: '',
                status: 'disponible',
                largeur: last.largeur,
                hauteur: last.hauteur,
                encadrement: last.encadrement,
                pret_a_accrocher: false,
                avec_cadre: false,
            });
        },

        removeTirage(index) {
            this.tirages.splice(index, 1);
        }
    }
}
</script>
@endpush
@endsection