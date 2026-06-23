@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
    {{-- Ici uniquement le contenu de la home :
    slider hero, artiste à la une, sélections, etc. --}}


    <section class="relative w-full h-[480px] grid grid-cols-1 md:grid-cols-2 overflow-hidden rounded-2xl p-4">

        {{-- SLIDER GAUCHE : campagnes pub (artistes/œuvres) --}}
        <div x-data="{
                    slides: {{ $campagnesHero->isNotEmpty() ? $campagnesHero->toJson() : '[]' }},
                    current: 0,
                    init() {
                        if (this.slides.length > 1) {
                            setInterval(() => {
                                this.current = (this.current + 1) % this.slides.length;
                            }, 5000);
                        }
                    }
                }" class="relative h-full bg-gray-100">
            <template x-if="slides.length === 0">
                <div class="w-full h-full flex items-center justify-center text-gray-400">
                    Aucune campagne active
                </div>
            </template>

            <template x-for="(slide, index) in slides" :key="slide.id">

                :href="slide.lien_cible"
                x-show="current === index"
                x-transition:enter="transition ease-out duration-700"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                class="absolute inset-0 block"
                >
                <img :src="'/storage/' + slide.visuel"
                    :alt="slide.type === 'artiste' ? slide.artiste?.nom : slide.oeuvre?.titre"
                    class="w-full h-full object-cover">
                <div class="absolute bottom-0 left-0 p-6 bg-gradient-to-t from-black/70 to-transparent w-full">
                    <p class="text-white text-xl font-semibold"
                        x-text="slide.type === 'artiste' ? slide.artiste?.nom : slide.oeuvre?.titre"></p>
                </div>
                </a>
            </template>

            {{-- Indicateurs --}}
            <div class="absolute bottom-4 right-4 flex gap-2" x-show="slides.length > 1">
                <template x-for="(slide, index) in slides" :key="index">
                    <button @click="current = index" :class="current === index ? 'bg-[#E8490F]' : 'bg-white/50'"
                        class="w-2.5 h-2.5 rounded-full transition"></button>
                </template>
            </div>
        </div>

        {{-- SLIDER DROITE : texte animé --}}
        <div x-data="{
                    messages: [
                        'Art3f, la galerie d\'art en ligne nouvelle génération',
                        'Des tirages uniques, signés par des artistes professionnels',
                        'Trouvez l\'œuvre qui vous correspond',
                    ],
                    current: 0,
                    init() {
                        setInterval(() => {
                            this.current = (this.current + 1) % this.messages.length;
                        }, 4000);
                    }
                }" class="relative h-full bg-[#1a1a1a] flex items-center justify-center px-10">
            <template x-for="(msg, index) in messages" :key="index">
                <h1 x-show="current === index" x-transition:enter="transition ease-out duration-700"
                    x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
                    class="absolute text-white text-3xl md:text-4xl font-bold text-center max-w-md" x-text="msg"></h1>
            </template>
        </div>

    </section>
    {{-- ARTISTE À LA UNE --}}
    @if($artisteUne)
        <section class="my-16 p-4">
            <h2 class="text-2xl font-bold mb-6">Artiste à la une</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 bg-gray-50 rounded-2xl p-8">

                {{-- Colonne gauche : photo + bio --}}
                <div class="flex flex-col">
                    <img src="{{ $artisteUne->photo ? asset('storage/' . $artisteUne->photo) : asset('images/default-artiste.jpg') }}"
                        alt="{{ $artisteUne->nom }}" class="w-32 h-32 rounded-full object-cover mb-4">
                    <h3 class="text-xl font-semibold">{{ $artisteUne->nom }}</h3>
                    <p class="text-gray-600 mt-2 line-clamp-4">{{ $artisteUne->bio }}</p>


                    <a href="{{ route('artistes.show', $artisteUne) }}"
                    class="mt-6 inline-block bg-[#E8490F] text-white px-6 py-3 rounded-2xl font-medium hover:opacity-90
                    transition w-fit"
                    >
                    Découvrir son univers
                    </a>
                </div>

                {{-- Colonne droite : aperçu œuvres --}}
                <div class="grid grid-cols-2 gap-4">
                    @foreach($artisteUne->oeuvres as $oeuvre)
                        <a href="{{ route('oeuvres.show', $oeuvre) }}" class="block rounded-2xl overflow-hidden aspect-square">
                            <img src="{{'./storage/app/public/' . $oeuvre->photo_principale}}" alt="{{ $oeuvre->titre }}"
                                class="w-full h-full object-cover hover:scale-105 transition duration-300">
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="text-center mt-6">
                <a href="{{ route('artistes.index') }}" class="text-[#E8490F] font-medium hover:underline">
                    Voir tous nos artistes →
                </a>
            </div>
        </section>
    @endif

@endsection