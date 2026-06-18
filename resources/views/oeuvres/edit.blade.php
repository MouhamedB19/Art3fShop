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
            <h1 class="text-2xl font-semibold text-gray-900">Modifier l'œuvre</h1>
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

        <form action="{{ route('oeuvres.update', $oeuvre->id) }}" method="POST" enctype="multipart/form-data"
              x-data="oeuvreForm()" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- ─── BLOC 1 : Informations générales ─── --}}
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="text-base font-medium text-gray-900">Informations générales</h2>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">

                    <div class="md:col-span-2">
                        <label class="block text-sm text-gray-700 mb-1.5">Titre <span class="text-[#E8490F]">*</span></label>
                        <input type="text" name="titre" value="{{ old('titre', $oeuvre->titre) }}"
                               class="w-full rounded-lg border border-gray-200 px-3.5 py-2.5 text-sm focus:outline-none focus:border-[#E8490F] focus:ring-1 focus:ring-[#E8490F] transition"
                               required>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 mb-1.5">Année de création <span class="text-[#E8490F]">*</span></label>
                        <input type="number" name="annee_de_creation"
                               value="{{ old('annee_de_creation', $oeuvre->annee_de_creation) }}"
                               min="1900" max="{{ date('Y') }}"
                               class="w-full rounded-lg border border-gray-200 px-3.5 py-2.5 text-sm focus:outline-none focus:border-[#E8490F] focus:ring-1 focus:ring-[#E8490F] transition"
                               required>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 mb-1.5">Orientation <span class="text-[#E8490F]">*</span></label>
                        <select name="orientation"
                                class="w-full rounded-lg border border-gray-200 px-3.5 py-2.5 text-sm focus:outline-none focus:border-[#E8490F] focus:ring-1 focus:ring-[#E8490F] transition bg-white" required>
                            <option value="">Choisir…</option>
                            @foreach(['portrait' => 'Portrait', 'paysage' => 'Paysage', 'carre' => 'Carré'] as $val => $label)
                                <option value="{{ $val }}" {{ old('orientation', $oeuvre->orientation) == $val ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 mb-1.5">Catégorie parente <span class="text-[#E8490F]">*</span></label>
                        <select name="categorie_parent_id" id="categorie_parent_id"
                                class="w-full rounded-lg border border-gray-200 px-3.5 py-2.5 text-sm focus:outline-none focus:border-[#E8490F] focus:ring-1 focus:ring-[#E8490F] transition bg-white">
                            <option value="">Choisir…</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ old('categorie_parent_id', $oeuvre->categorie->id_categorie_parente ?? $oeuvre->categorie_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->nom_categorie }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div id="sous-categorie-div">
                        <label class="block text-sm text-gray-700 mb-1.5">Sous-catégorie</label>
                        <select name="categorie_id" id="categorie_id"
                                class="w-full rounded-lg border border-gray-200 px-3.5 py-2.5 text-sm focus:outline-none focus:border-[#E8490F] focus:ring-1 focus:ring-[#E8490F] transition bg-white">
                            <option value="">-- Choisir --</option>
                            

                        </select>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 mb-1.5">Support <span class="text-[#E8490F]">*</span></label>
                        <select name="support_id"
                                class="w-full rounded-lg border border-gray-200 px-3.5 py-2.5 text-sm focus:outline-none focus:border-[#E8490F] focus:ring-1 focus:ring-[#E8490F] transition bg-white" required>
                            <option value="">Choisir…</option>
                            @foreach($supports as $support)
                                <option value="{{ $support->id }}" {{ old('support_id', $oeuvre->support_id) == $support->id ? 'selected' : '' }}>
                                    {{ $support->nom_support }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm text-gray-700 mb-1.5">Taux de réduction <span class="text-gray-400 font-normal">(optionnel)</span></label>
                        <div class="relative">
                            <input type="number" name="taux_reduction"
                                   value="{{ old('taux_reduction', $oeuvre->taux_reduction) }}"
                                   min="0" max="0.99" step="0.01"
                                   class="w-full rounded-lg border border-gray-200 px-3.5 py-2.5 pr-8 text-sm focus:outline-none focus:border-[#E8490F] focus:ring-1 focus:ring-[#E8490F] transition"
                                   placeholder="0.15">
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">%</span>
                        </div>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm text-gray-700 mb-1.5">Description <span class="text-[#E8490F]">*</span></label>
                        <textarea name="description" rows="3"
                                  class="w-full rounded-lg border border-gray-200 px-3.5 py-2.5 text-sm focus:outline-none focus:border-[#E8490F] focus:ring-1 focus:ring-[#E8490F] transition resize-none"
                                  required>{{ old('description', $oeuvre->description) }}</textarea>
                    </div>

                    <div class="flex items-center gap-3">
                        <input type="hidden" name="visible" value="0">
                        <input type="checkbox" name="visible" id="visible" value="1"
                               {{ old('visible', $oeuvre->visible) ? 'checked' : '' }}
                               class="w-4 h-4 rounded border-gray-300 accent-[#E8490F]">
                        <label for="visible" class="text-sm text-gray-700">Visible dans le catalogue</label>
                    </div>

                </div>
            </div>

            {{-- ─── BLOC 2 : Photo principale ─── --}}
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="text-base font-medium text-gray-900">Photo principale</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Laisser vide pour conserver la photo actuelle.</p>
                </div>
                <div class="p-6 flex items-start gap-6">

                    {{-- Photo actuelle --}}
                    <div class="shrink-0">
                        <p class="text-xs text-gray-500 mb-2">Photo actuelle</p>
                        <img src="{{ asset('storage/' . $oeuvre->photo_principale) }}"
                             alt="{{ $oeuvre->titre }}"
                             class="w-28 h-28 object-cover rounded-xl border border-gray-200">
                    </div>

                    {{-- Upload nouvelle photo --}}
                    <label class="flex flex-col items-center justify-center flex-1 h-28 border-2 border-dashed border-gray-200 rounded-xl cursor-pointer hover:border-[#E8490F] hover:bg-orange-50 transition group">
                        <template x-if="!previewUrl">
                            <div class="text-center">
                                <svg class="w-6 h-6 text-gray-300 mx-auto mb-1 group-hover:text-[#E8490F] transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"/>
                                </svg>
                                <p class="text-sm text-gray-500">Nouvelle photo</p>
                                <p class="text-xs text-gray-400 mt-0.5">JPG, PNG, TIFF — min 600×600px — max 10 Mo</p>
                            </div>
                        </template>
                        <template x-if="previewUrl">
                            <img :src="previewUrl" class="h-full w-full object-contain rounded-lg">
                        </template>
                        <input type="file" name="photo_principale" accept="image/jpeg,image/png,image/tiff"
                               class="hidden" x-on:change="handleFile($event.target.files[0])">
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
                                           {{ $oeuvre->themes->contains($theme->id) ? 'checked' : '' }}
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
                                           {{ $oeuvre->couleurs->contains($couleur->id) ? 'checked' : '' }}
                                           class="hidden peer">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs border border-gray-200 text-gray-600
                                                 peer-checked:border-[#E8490F] peer-checked:text-[#E8490F] transition">
                                        @if($couleur->hex ?? null)
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
                        <p class="text-xs text-gray-400 mt-0.5">Les tirages déjà vendus ne peuvent pas être modifiés.</p>
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
                    <template x-for="(tirage, index) in tirages" :key="tirage.uid">
                        <div class="p-6" :class="tirage.vendu ? 'opacity-60' : ''">

                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-medium text-gray-700" x-text="'Tirage #' + tirage.numero"></span>
                                    <span x-show="tirage.vendu"
                                          class="text-xs px-2 py-0.5 rounded-full bg-gray-100 text-gray-500">
                                        Vendu — non modifiable
                                    </span>
                                </div>
                                <button type="button"
                                        x-show="!tirage.vendu && tirages.filter(t => !t.vendu).length > 1"
                                        x-on:click="removeTirage(index)"
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
                                    <input type="number" :name="tirage.vendu ? '' : 'tirages[' + index + '][numero]'"
                                           x-model="tirage.numero" min="1"
                                           :disabled="tirage.vendu"
                                           class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:border-[#E8490F] focus:ring-1 focus:ring-[#E8490F] transition disabled:bg-gray-50 disabled:text-gray-400" required>
                                </div>

                                <div>
                                    <label class="block text-xs text-gray-500 mb-1.5">Prix (€) <span class="text-[#E8490F]">*</span></label>
                                    <input type="number" :name="tirage.vendu ? '' : 'tirages[' + index + '][prix]'"
                                           x-model="tirage.prix" min="0" step="0.01"
                                           :disabled="tirage.vendu"
                                           class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:border-[#E8490F] focus:ring-1 focus:ring-[#E8490F] transition disabled:bg-gray-50 disabled:text-gray-400" required>
                                </div>

                                <div>
                                    <label class="block text-xs text-gray-500 mb-1.5">Statut <span class="text-[#E8490F]">*</span></label>
                                    <select :name="tirage.vendu ? '' : 'tirages[' + index + '][status]'"
                                            x-model="tirage.status" :disabled="tirage.vendu"
                                            class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:border-[#E8490F] focus:ring-1 focus:ring-[#E8490F] transition bg-white disabled:bg-gray-50 disabled:text-gray-400" required>
                                        <option value="disponible">Disponible</option>
                                        <option value="vendu">Vendu</option>
                                        <option value="reserve">Réservé</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs text-gray-500 mb-1.5">Largeur (cm) <span class="text-[#E8490F]">*</span></label>
                                    <input type="number" :name="tirage.vendu ? '' : 'tirages[' + index + '][largeur]'"
                                           x-model="tirage.largeur" min="1" step="0.5"
                                           :disabled="tirage.vendu"
                                           class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:border-[#E8490F] focus:ring-1 focus:ring-[#E8490F] transition disabled:bg-gray-50 disabled:text-gray-400" required>
                                </div>

                                <div>
                                    <label class="block text-xs text-gray-500 mb-1.5">Hauteur (cm) <span class="text-[#E8490F]">*</span></label>
                                    <input type="number" :name="tirage.vendu ? '' : 'tirages[' + index + '][hauteur]'"
                                           x-model="tirage.hauteur" min="1" step="0.5"
                                           :disabled="tirage.vendu"
                                           class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:border-[#E8490F] focus:ring-1 focus:ring-[#E8490F] transition disabled:bg-gray-50 disabled:text-gray-400" required>
                                </div>

                                <div>
                                    <label class="block text-xs text-gray-500 mb-1.5">Encadrement</label>
                                    <select :name="tirage.vendu ? '' : 'tirages[' + index + '][encadrement]'"
                                            x-model="tirage.encadrement" :disabled="tirage.vendu"
                                            class="w-full rounded-lg border border-gray-200 px-3 py-2 text-sm focus:outline-none focus:border-[#E8490F] focus:ring-1 focus:ring-[#E8490F] transition bg-white disabled:bg-gray-50">
                                        <option value="0">Sans cadre</option>
                                        <option value="1">Avec cadre</option>
                                    </select>
                                </div>

                                <div class="flex items-center gap-2">
                                    <input type="hidden" :name="tirage.vendu ? '' : 'tirages[' + index + '][pret_a_accrocher]'" value="0">
                                    <input type="checkbox" :name="tirage.vendu ? '' : 'tirages[' + index + '][pret_a_accrocher]'"
                                           :id="'pret_' + index" x-model="tirage.pret_a_accrocher" value="1"
                                           :disabled="tirage.vendu"
                                           class="w-4 h-4 rounded border-gray-300 accent-[#E8490F]">
                                    <label :for="'pret_' + index" class="text-xs text-gray-600">Prêt à accrocher</label>
                                </div>

                                <div class="flex items-center gap-2">
                                    <input type="hidden" :name="tirage.vendu ? '' : 'tirages[' + index + '][avec_cadre]'" value="0">
                                    <input type="checkbox" :name="tirage.vendu ? '' : 'tirages[' + index + '][avec_cadre]'"
                                           :id="'cadre_' + index" x-model="tirage.avec_cadre" value="1"
                                           :disabled="tirage.vendu"
                                           class="w-4 h-4 rounded border-gray-300 accent-[#E8490F]">
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
                        Enregistrer les modifications
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

            // Tirages chargés depuis PHP (pré-remplis)
            tirages: {{ Js::from($oeuvre->tirages->map(function($t) {
                return [
                    'uid'              => $t->id,
                    'numero'           => $t->numero,
                    'prix'             => $t->prix,
                    'status'           => $t->status,
                    'largeur'          => $t->dimension?->largeur,
                    'hauteur'          => $t->dimension?->hauteur,
                    'encadrement'      => $t->encadrement,
                    'pret_a_accrocher' => (bool) $t->pret_a_accrocher,
                    'avec_cadre'       => (bool) $t->avec_cadre,
                    'vendu'            => $t->status === 'vendu',
                ];
            })) }},

            handleFile(file) {
                if (!file) return;
                const reader = new FileReader();
                reader.onload = e => this.previewUrl = e.target.result;
                reader.readAsDataURL(file);
            },

            addTirage() {
                const editables = this.tirages.filter(t => !t.vendu);
                const last = editables[editables.length - 1] ?? this.tirages[this.tirages.length - 1];
                this.tirages.push({
                    uid:              Date.now(),
                    numero:           (last?.numero ?? 0) + 1,
                    prix:             '',
                    status:           'disponible',
                    largeur:          last?.largeur ?? '',
                    hauteur:          last?.hauteur ?? '',
                    encadrement:      last?.encadrement ?? 'sans',
                    pret_a_accrocher: false,
                    avec_cadre:       false,
                    vendu:            false,
                });
            },

            removeTirage(index) {
                this.tirages.splice(index, 1);
            }
        }
    }
    </script>

    <script>
    // Logique sous-catégories (reprise de l'existant)
    document.addEventListener('DOMContentLoaded', function () {
        const parentSelect  = document.getElementById('categorie_parent_id');
        const sousCatDiv    = document.getElementById('sous-categorie-div');
        const sousCatSelect = document.getElementById('categorie_id');
        const currentCatId  = {{ $oeuvre->categorie_id }};
        const parentId      = {{ $oeuvre->categorie->id_categorie_parente ?? 'null' }};

        function loadSousCategories(parentId, selectedId) {
            if (!parentId) 
            { 
                sousCatDiv.style.display = 'none'; 
                return; 
            }
            fetch(`/categories/${parentId}/sous-categories`)
                .then(r => r.json())
                .then(sousCats => {
                    if (sousCats.length === 0) {
                        sousCatDiv.style.display = 'none';
                        sousCatSelect.value = parentId;
                    } else {
                        sousCatDiv.style.display = 'block';
                        sousCatSelect.innerHTML = '<option value="">-- Choisir --</option>';
                        sousCats.forEach(sc => {
                            const opt = document.createElement('option');
                            opt.value    = sc.id;
                            opt.text     = sc.nom_categorie;
                            opt.selected = sc.id == selectedId;
                            sousCatSelect.appendChild(opt);
                        });
                    }
                });
        }

        // Pré-charger les sous-catégories au chargement
        if (parentId) {
            parentSelect.value = parentId;
            loadSousCategories(parentId, currentCatId);
        }

        parentSelect.addEventListener('change', function () {
            loadSousCategories(this.value, null);
        });
    });
    </script>
@endpush
@endsection