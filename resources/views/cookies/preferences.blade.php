@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto px-4 py-10" x-data="cookiePreferences()">

        <h1 class="text-2xl font-bold mb-2">Gestion des cookies</h1>
        <p class="text-sm text-gray-500 mb-8">
            Choisis les catégories de cookies que tu acceptes. Tu peux changer d'avis à tout moment en revenant sur cette
            page.
        </p>

        <div x-show="saved" x-cloak x-transition class="mb-6 p-3 rounded bg-green-100 text-green-800 text-sm">
            Préférences sauvegardées.
        </div>

        <div class="space-y-4">

            {{-- Nécessaires : toujours actif, non désactivable --}}
            <div class="flex items-start justify-between border rounded-lg p-4">
                <div class="pr-4">
                    <h2 class="font-semibold text-gray-900">Nécessaires</h2>
                    <p class="text-sm text-gray-500">
                        Indispensables au fonctionnement du site (panier, connexion, sécurité). Toujours actifs.
                    </p>
                </div>
                <input type="checkbox" checked disabled class="mt-1 w-5 h-5 opacity-50">
            </div>

            <div class="flex items-start justify-between border rounded-lg p-4">
                <div class="pr-4">
                    <h2 class="font-semibold text-gray-900">Préférences</h2>
                    <p class="text-sm text-gray-500">
                        Mémorisent tes choix d'affichage (filtres récents, favoris locaux).
                    </p>
                </div>
                <input type="checkbox" x-model="prefs.preferences" class="mt-1 w-5 h-5">
            </div>

            <div class="flex items-start justify-between border rounded-lg p-4">
                <div class="pr-4">
                    <h2 class="font-semibold text-gray-900">Analytics</h2>
                    <p class="text-sm text-gray-500">
                        Mesure d'audience anonymisée pour comprendre l'usage du site.
                    </p>
                </div>
                <input type="checkbox" x-model="prefs.analytics" class="mt-1 w-5 h-5">
            </div>

            <div class="flex items-start justify-between border rounded-lg p-4">
                <div class="pr-4">
                    <h2 class="font-semibold text-gray-900">Marketing</h2>
                    <p class="text-sm text-gray-500">
                        Permettent de te proposer des contenus ou offres personnalisées.
                    </p>
                </div>
                <input type="checkbox" x-model="prefs.marketing" class="mt-1 w-5 h-5">
            </div>

            <div class="flex items-start justify-between border rounded-lg p-4">
                <div class="pr-4">
                    <h2 class="font-semibold text-gray-900">Tiers</h2>
                    <p class="text-sm text-gray-500">
                        Services externes intégrés au site (cartes, vidéos, partage social).
                    </p>
                </div>
                <input type="checkbox" x-model="prefs.tiers" class="mt-1 w-5 h-5">
            </div>

        </div>

        <div class="flex gap-3 mt-8">
            <button @click="toutAccepter()" class="px-4 py-2 text-sm rounded border text-gray-700 hover:bg-gray-50">
                Tout accepter
            </button>
            <form action="{{ route('cookie.save') }}" method="GET">
                <button @click="sauvegarder()" class="px-4 py-2 text-sm rounded text-white" style="background-color:#E8490F">
                    Sauvegarder mes préférences
                </button>
            </form>
        </div>

    </div>

    <script>
        function cookiePreferences() {
            return {
                prefs: window.cookieConsent.getConsent() ?? window.cookieConsent.defaultPrefs(),
                saved: false,

                sauvegarder() {
                    this.prefs.necessaires = true;
                    window.cookieConsent.setConsent(this.prefs);
                    this.saved = true;
                    setTimeout(() => this.saved = false, 3000);
                },

                toutAccepter() {
                    this.prefs = window.cookieConsent.allAcceptedPrefs();
                    this.sauvegarder();
                },
            }
        }
    </script>
@endsection