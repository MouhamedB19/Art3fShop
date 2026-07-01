@extends('layouts.app')
@section('title', 'Mes œuvres')

@section('content')
    <div class="min-h-screen bg-gray-50 py-8 px-4">
        <div class="max-w-6xl mx-auto">
        
            {{-- Header --}}
            <div class="flex items-start justify-between mb-8">
                <div>
                    <p class="text-sm text-gray-400 mb-1">Bienvenue,</p>
                    <h1 class="text-2xl font-semibold text-gray-900">
                        {{ Auth::user()->artiste->nom_d_artiste ?? Auth::user()->prenom . ' ' . Auth::user()->nom }}
                    </h1>
                    <p class="text-sm text-gray-500 mt-1">Votre musée personnel</p>
                </div>
                <a href="{{ route('oeuvres.create') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-[#E8490F] text-white text-sm font-medium hover:bg-[#c93d0c] transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Ajouter une œuvre
                </a>
            </div>
        
            {{-- Flash success --}}
            @if(session('success'))
                <div class="mb-6 flex items-center gap-3 p-4 bg-green-50 border border-green-200 rounded-xl text-sm text-green-700">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif
            
            {{-- Stats rapides --}}
            @php
                $total     = $oeuvres->count();
                $dispo     = $oeuvres->sum(fn($o) => $o->tirages->where('status', 'disponible')->count());
                $vendus    = $oeuvres->sum(fn($o) => $o->tirages->where('status', 'vendu')->count());
                $invisibles = $oeuvres->where('visible', false)->count();
            @endphp
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                @foreach([
                    ['label' => 'Œuvres', 'value' => $total, 'color' => 'text-gray-900'],
                    ['label' => 'Tirages dispo', 'value' => $dispo, 'color' => 'text-green-600'],
                    ['label' => 'Vendus', 'value' => $vendus, 'color' => 'text-[#E8490F]'],
                    ['label' => 'Non visibles', 'value' => $invisibles, 'color' => 'text-gray-400'],
                ] as $stat)
                    <x-carte-stats titre="{{ $stat['label'] }}" couleur="{{ $stat['color'] }}" valeur="{{ $stat['value'] }}"/>
                @endforeach
            </div>
        
            {{-- Liste des œuvres --}}
            @if($oeuvres->isEmpty())
                <div class="bg-white rounded-2xl border border-gray-200 p-16 text-center">
                    <svg class="w-12 h-12 text-gray-200 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4-4m0 0l4 4m-4-4v8M4 8V6a2 2 0 012-2h12a2 2 0 012 2v10"/>
                    </svg>
                    <p class="text-gray-500 text-sm">Vous n'avez pas encore ajouté d'œuvre.</p>
                    <a href="{{ route('oeuvres.create') }}"
                       class="inline-block mt-4 px-5 py-2 rounded-lg bg-[#E8490F] text-white text-sm hover:bg-[#c93d0c] transition">
                        Ajouter ma première œuvre
                    </a>
                </div>
            @else
                <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-100 text-xs text-gray-400 uppercase tracking-wide">
                                <th class="px-6 py-3 text-left font-medium">Œuvre</th>
                                <th class="px-6 py-3 text-left font-medium hidden md:table-cell">Catégorie</th>
                                <th class="px-6 py-3 text-center font-medium hidden md:table-cell">Tirages</th>
                                <th class="px-6 py-3 text-center font-medium">Visibilité</th>
                                <th class="px-6 py-3 text-right font-medium">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($oeuvres as $oeuvre)
                            <tr class="hover:bg-gray-50 transition group">
                            
                                {{-- Photo + titre --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <img src="{{ asset('storage/' . $oeuvre->photo_principale) }}"
                                             alt="{{ $oeuvre->titre }}"
                                             class="w-14 h-14 object-cover rounded-lg border border-gray-100 shrink-0">
                                        <div>
                                            <p class="font-medium text-gray-900">{{ $oeuvre->titre }}</p>
                                            <p class="text-xs text-gray-400 mt-0.5">{{ $oeuvre->annee_de_creation }}</p>
                                        </div>
                                    </div>
                                </td>
                            
                                {{-- Catégorie --}}
                                <td class="px-6 py-4 hidden md:table-cell">
                                    <span class="text-gray-600">{{ $oeuvre->categorie?->nom_categorie ?? '—' }}</span>
                                </td>
                            
                                {{-- Tirages --}}
                                <td class="px-6 py-4 hidden md:table-cell text-center">
                                    @php
                                        $nbDispo  = $oeuvre->tirages->where('status', 'disponible')->count();
                                        $nbTotal  = $oeuvre->tirages->count();
                                    @endphp
                                    <span class="inline-flex items-center gap-1 text-xs px-2.5 py-1 rounded-full
                                        {{ $nbDispo > 0 ? 'bg-green-50 text-green-700' : 'bg-gray-100 text-gray-400' }}">
                                        {{ $nbDispo }}/{{ $nbTotal }} dispo
                                    </span>
                                </td>
                            
                                {{-- Visibilité --}}
                                <td class="px-6 py-4 text-center">
                                    @if($oeuvre->visible)
                                        <span class="inline-block w-2 h-2 rounded-full bg-green-400" title="Visible"></span>
                                    @else
                                        <span class="inline-block w-2 h-2 rounded-full bg-gray-300" title="Masqué"></span>
                                    @endif
                                </td>
                            
                                {{-- Actions --}}
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('oeuvres.edit', $oeuvre) }}"
                                           class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-gray-200 text-xs text-gray-600 hover:border-[#E8490F] hover:text-[#E8490F] transition">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            Modifier
                                        </a>
                                    
                                        <form method="POST" action="{{ route('oeuvres.destroy', $oeuvre) }}"
                                              x-data
                                              x-on:submit.prevent="if(confirm('Supprimer « {{ addslashes($oeuvre->titre) }} » ? Cette action est irréversible.')) $el.submit()">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-gray-200 text-xs text-gray-400 hover:border-red-300 hover:text-red-500 transition">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M8 7V4h8v3"/>
                                                </svg>
                                                Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            
                {{-- Footer navigation --}}
                <div class="mt-6 flex justify-end">
                    <a href="{{ route('dashboard') }}"
                       class="text-sm text-gray-400 hover:text-gray-600 transition">
                        ← Retour au tableau de bord
                    </a>
                </div>
            @endif
            
        </div>
    </div>
@endsection