<div x-data="cookieBanner()" x-show="visible" x-cloak x-transition
    class="fixed bottom-0 inset-x-0 z-50 bg-white border-t shadow-lg">
    <div class="max-w-5xl mx-auto px-4 py-4 flex flex-col sm:flex-row sm:items-center gap-4">

        <p class="text-sm text-gray-600 flex-1">
            On utilise des cookies pour faire fonctionner le site, mesurer l'audience et, si tu l'acceptes,
            personnaliser ton expérience. Tu peux gérer tes préférences à tout moment depuis le
            <a href="{{ route('cookies.preferences') }}" class="underline" style="color:#E8490F">centre de
                préférences</a>.
        </p>

        <div class="flex gap-2 shrink-0">
            <a href="{{ route('cookies.preferences') }}"
                class="px-4 py-2 text-sm rounded border text-gray-700 hover:bg-gray-50">
                Personnaliser
            </a>
            <button @click="refuserTout()" class="px-4 py-2 text-sm rounded border text-gray-700 hover:bg-gray-50">
                Tout refuser
            </button>
            <button @click="accepterTout()" class="px-4 py-2 text-sm rounded text-white"
                style="background-color:#E8490F">
                Tout accepter
            </button>
        </div>

    </div>
</div>

<script>
    function cookieBanner() {
        return {
            visible: false,

            init() {
                this.visible = window.cookieConsent.getConsent() === null;
            },

            accepterTout() {
                window.cookieConsent.setConsent(window.cookieConsent.allAcceptedPrefs());
                this.visible = false;
            },

            refuserTout() {
                window.cookieConsent.setConsent(window.cookieConsent.defaultPrefs());
                this.visible = false;
            },
        }
    }
</script>