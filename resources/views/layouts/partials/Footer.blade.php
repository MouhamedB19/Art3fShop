{{--
    ┌─────────────────────────────────────────────────────────────┐
    │  FOOTER — art3f Shop                                        │
    │  resources/views/layouts/partials/footer.blade.php          │
    │                                                             │
    │  Utilisation dans app.blade.php :                           │
    │      @include('layouts.partials.footer')                    │
    └─────────────────────────────────────────────────────────────┘
--}}

<footer class="bg-[#1A1A1A] text-white mt-16">

    {{-- ═══════════════════════════════════════════════════════════
         SECTION NEWSLETTER
         ═══════════════════════════════════════════════════════════ --}}
    <div class="border-b border-white/10">
        <div class="max-w-screen-xl mx-auto px-4 py-10">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">

                <div>
                    <p class="text-lg font-bold flex items-center gap-2">
                        <span class="text-[#E8490F]">✦</span>
                        Inscrivez-vous à notre newsletter
                    </p>
                    <p class="text-sm text-gray-400 mt-1">
                        Profitez d'offres exclusives… ou obtenez des infos exclusives, la primeur des infos…
                    </p>
                </div>

                <form
                    method="POST"
                    action="{{ route('newsletter.subscribe') }}"
                    class="flex gap-2 w-full md:w-auto md:min-w-[400px]"
                    x-data="{ email: '', loading: false, success: false }"
                    @submit.prevent="
                        loading = true;
                        fetch('{{ route('newsletter.subscribe') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                            },
                            body: JSON.stringify({ email })
                        })
                        .then(r => r.json())
                        .then(() => { success = true; loading = false; })
                        .catch(() => loading = false)
                    "
                >
                    @csrf
                    <template x-if="!success">
                        <div class="flex gap-2 w-full">
                            <input
                                type="email"
                                x-model="email"
                                placeholder="Votre adresse email…"
                                required
                                class="flex-1 px-4 py-2.5 bg-white/10 border border-white/20 rounded-lg
                                       text-sm placeholder-gray-400 text-white
                                       focus:outline-none focus:ring-2 focus:ring-[#E8490F] focus:border-transparent
                                       transition-all"
                            >
                            <x-button-art3f label="S'inscrire" />
                        </div>
                    </template>
                    <template x-if="success">
                        <p class="text-green-400 text-sm font-medium flex items-center gap-2 py-2.5">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Merci ! Vous êtes bien inscrit(e).
                        </p>
                    </template>
                </form>

            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════
         MENUS (4 colonnes)
         ═══════════════════════════════════════════════════════════ --}}
    <div class="max-w-screen-xl mx-auto px-4 py-12">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 lg:gap-12">

            {{-- ── Colonne 1 : ART3F SHOP ──────────────────────── --}}
            <div>
                <p class="text-xs font-bold text-[#E8490F] uppercase tracking-widest mb-4 flex items-center gap-1">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <circle cx="10" cy="10" r="10"/>
                    </svg>
                    art3f Shop
                </p>
                <ul class="space-y-2.5">
                    @foreach([
                        [route('about'),              'À propos de nous'],
                        [route('equipe'),             'L\'équipe'],
                        [route('emploi'),             'Emploi'],
                        [route('artistes.index'),     'Nos artistes'],
                        [route('blog.index'),         'Magazine | Blog'],
                        [route('criteres'),           'Critères de sélection'],
                        [route('contact'),            'Contact'],
                    ] as [$url, $label])
                        <li>
                            <x-lien-art3f :href="$url" :label="$label" />
                        </li>
                    @endforeach
                </ul>

                {{-- Réseaux sociaux --}}
                <div class="flex items-center gap-3 mt-6">
                    <p class="text-xs text-gray-500 italic">Suivez-nous</p>
                    {{-- LinkedIn --}}
                    <a href="{{ config('art3f.linkedin', '#') }}" target="_blank" rel="noopener"
                       class="text-gray-400 hover:text-white transition-colors"
                       aria-label="LinkedIn">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/>
                            <circle cx="4" cy="4" r="2"/>
                        </svg>
                    </a>
                    {{-- Facebook --}}
                    <a href="{{ config('art3f.facebook', '#') }}" target="_blank" rel="noopener"
                       class="text-gray-400 hover:text-white transition-colors"
                       aria-label="Facebook">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/>
                        </svg>
                    </a>
                    {{-- Instagram --}}
                    <a href="{{ config('art3f.instagram', '#') }}" target="_blank" rel="noopener"
                       class="text-gray-400 hover:text-white transition-colors"
                       aria-label="Instagram">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                            <circle cx="12" cy="12" r="4"/>
                            <circle cx="17.5" cy="6.5" r="0.5" fill="currentColor"/>
                        </svg>
                    </a>
                    {{-- Email / Newsletter --}}
                    <a href="{{ route('newsletter.page') }}"
                       class="text-gray-400 hover:text-white transition-colors"
                       aria-label="Newsletter">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0
                                     01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25
                                     0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5
                                     4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/>
                        </svg>
                    </a>
                </div>
            </div>

            {{-- ── Colonne 2 : CLIENTS ─────────────────────────── --}}
            <div>
                <p class="text-xs font-bold text-[#E8490F] uppercase tracking-widest mb-4 flex items-center gap-1">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <circle cx="10" cy="10" r="10"/>
                    </svg>
                    Clients
                </p>
                <ul class="space-y-2.5">
                    @foreach([
                        [route('compte.index'),        'Mon compte'],
                        [route('mentions-legales'),    'Mentions légales'],
                        [route('cgv'),                 'CGV'],
                        [route('cookies.preferences'),             'Gestion des cookies'],
                        ['https://aide.art3f.com',     'FAQ'],
                        [route('carte-cadeaux'),       'Carte cadeaux'],
                        [route('oeuvre-sur-mesure'),   'Votre œuvre sur mesure'],
                    ] as [$url, $label])
                        <li>
                            <x-lien-art3f :href="$url" :label="$label" />
                        </li>
                    @endforeach
                    <li>
                        <a href="{{ route('entreprises') }}"
                           class="text-sm font-semibold text-gray-300 hover:text-white transition-colors">
                            Pour les entreprises
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('designers') }}"
                           class="text-sm font-semibold text-gray-300 hover:text-white transition-colors">
                            Pour les designers d'intérieurs
                        </a>
                    </li>
                </ul>
            </div>

            {{-- ── Colonne 3 : CONTACT ─────────────────────────── --}}
            <div>
                <p class="text-xs font-bold text-[#E8490F] uppercase tracking-widest mb-4 flex items-center gap-1">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <circle cx="10" cy="10" r="10"/>
                    </svg>
                    Contact
                </p>
                <ul class="space-y-2.5">

                    {{-- Téléphone --}}
                    @if(config('art3f.telephone'))
                        <li>
                            <a href="tel:{{ config('art3f.telephone') }}"
                               class="text-sm text-gray-400 hover:text-white transition-colors flex items-center gap-2">
                                <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0
                                             01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1
                                             1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716
                                             21 3 14.284 3 6V5z"/>
                                </svg>
                                {{ config('art3f.telephone') }}
                            </a>
                        </li>
                    @endif

                    {{-- Formulaire de contact --}}
                    <li>
                        <x-lien-art3f :href="route('contact')" label="Formulaire de contact" />
                    </li>

                    {{-- Chat --}}
                    <li>
                        <button
                            onclick="if(window.Intercom) Intercom('show')"
                            class="text-sm text-gray-400 hover:text-white transition-colors text-left">
                            Chat en ligne
                        </button>
                    </li>

                </ul>
            </div>

            {{-- ── Colonne 4 : ARTISTES ────────────────────────── --}}
            <div>
                <p class="text-xs font-bold text-[#E8490F] uppercase tracking-widest mb-4 flex items-center gap-1">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                        <circle cx="10" cy="10" r="10"/>
                    </svg>
                    Artistes
                </p>
                <ul class="space-y-2.5">
                    <li>
                        <x-lien-art3f :href="route('artiste.compte')" label="Espace exposant" />
                    </li>
                    <li>
                        <x-lien-art3f :href="'https://aide.art3f.com'" label="FAQ artistes" />
                    </li>
                </ul>

                {{-- CTA Exposer --}}
                <div class="mt-5 p-4 border border-white/10 rounded-xl">
                    <p class="text-sm font-bold text-white mb-1">
                        Vous souhaitez exposer sur art3f shop ?
                    </p>
                    <a href="{{ route('artiste.inscription') }}"
                       class="inline-flex items-center gap-1 text-xs text-[#E8490F] hover:underline font-medium mt-1">
                        Compléter votre dossier d'inscription
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>
            </div>

        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════
         BANNIÈRE DE RÉASSURANCE (fond orange)
         ═══════════════════════════════════════════════════════════ --}}
    <div class="bg-[#E8490F]">
        <div class="max-w-screen-xl mx-auto px-4 py-5">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

                @foreach([
                    [
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z"/>',
                        'label' => 'Artistes reconnus',
                        'sub'   => 'ou en devenir',
                    ],
                    [
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z"/>',
                        'label' => 'Livraison internationale',
                        'sub'   => 'Offerte dans l\'UE',
                    ],
                    [
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3"/>',
                        'label' => 'Retour gratuit',
                        'sub'   => '30 jours pour changer d\'avis',
                    ],
                    [
                        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>',
                        'label' => 'Paiements sécurisés',
                        'sub'   => 'Stripe — 3D Secure',
                    ],
                ] as $item)
                    <div class="flex items-center gap-3 text-white">
                        <svg class="w-8 h-8 shrink-0 opacity-90" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            {!! $item['icon'] !!}
                        </svg>
                        <div>
                            <p class="text-sm font-bold leading-tight">{{ $item['label'] }}</p>
                            <p class="text-xs opacity-80">{{ $item['sub'] }}</p>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════
         BAS DU FOOTER — copyright + légal
         ═══════════════════════════════════════════════════════════ --}}
    <div class="border-t border-white/5 bg-black/30">
        <div class="max-w-screen-xl mx-auto px-4 py-4
                    flex flex-col sm:flex-row items-center justify-between gap-2
                    text-xs text-gray-500">
            <p>© {{ date('Y') }} art3f Shop — Tous droits réservés</p>
            <div class="flex items-center gap-4">
                <a href="{{ route('mentions-legales') }}"
                   class="hover:text-gray-300 transition-colors">Mentions légales</a>
                <a href="{{ route('cgv') }}"
                   class="hover:text-gray-300 transition-colors">CGV</a>
                <a href="{{ route('cookies.preferences') }}"
                   class="hover:text-gray-300 transition-colors">Cookies</a>
            </div>
        </div>
    </div>

</footer>

{{-- Bouton retour en haut --}}
<button
    x-data="{ show: false }"
    x-init="window.addEventListener('scroll', () => show = window.scrollY > 400)"
    x-show="show"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0 translate-y-2"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
    class="fixed bottom-6 right-6 z-40 w-10 h-10 bg-[#1A1A1A] hover:bg-[#E8490F]
           text-white rounded-full shadow-lg flex items-center justify-center
           transition-colors duration-200 cursor-pointer"
    aria-label="Retour en haut">
    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
    </svg>
</button>

{{--
    ─────────────────────────────────────────────────────────────
    ROUTES nécessaires (web.php) :
    ─────────────────────────────────────────────────────────────
    Route::post('/newsletter/subscribe', ...)->name('newsletter.subscribe');
    Route::get('/newsletter', ...)->name('newsletter.page');
    Route::get('/a-propos', ...)->name('about');
    Route::get('/equipe', ...)->name('equipe');
    Route::get('/emploi', ...)->name('emploi');
    Route::get('/blog', ...)->name('blog.index');
    Route::get('/criteres-selection', ...)->name('criteres');
    Route::get('/contact', ...)->name('contact');
    Route::get('/mentions-legales', ...)->name('mentions-legales');
    Route::get('/cgv', ...)->name('cgv');
    Route::get('/cookies', ...)->name('cookies');
    Route::get('/carte-cadeaux', ...)->name('carte-cadeaux');
    Route::get('/oeuvre-sur-mesure', ...)->name('oeuvre-sur-mesure');
    Route::get('/entreprises', ...)->name('entreprises');
    Route::get('/designers-interieurs', ...)->name('designers');
    Route::get('/artiste/compte', ...)->name('artiste.compte');
    Route::get('/artiste/inscription', ...)->name('artiste.inscription');
    ─────────────────────────────────────────────────────────────
    CONFIG (config/art3f.php) :
    ─────────────────────────────────────────────────────────────
    return [
        'promo_message' => '15€ offerts sur votre première commande en vous inscrivant à la newsletter !',
        'promo_url'     => '/register',
        'telephone'     => '+33 (0)1 XX XX XX XX',
        'linkedin'      => 'https://linkedin.com/company/art3f',
        'facebook'      => 'https://facebook.com/art3f',
        'instagram'     => 'https://instagram.com/art3f',
    ];
    ─────────────────────────────────────────────────────────────
--}}
