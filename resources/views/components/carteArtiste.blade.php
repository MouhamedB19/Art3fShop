<a href="{{ route('artistes.show', $artiste->id) }}" class="group block bg-white rounded-2xl overflow-hidden shadow-sm
          hover:shadow-xl transition-shadow duration-300">

    {{-- Photo œuvre --}}
    <div class="relative h-52 bg-gray-100 overflow-hidden">

        @if($oeuvrePhoto)
            <img src="{{ asset('storage/' . $oeuvrePhoto) }}" alt="Œuvre de {{ $nom }}" class="w-full h-full object-cover transition-transform
                                    duration-500 group-hover:scale-105" loading="lazy">
        @else
            <div class="w-full h-full bg-gradient-to-br
                                    from-gray-200 to-gray-300 flex items-center
                                    justify-center">
                <span class="text-5xl font-black text-gray-400">
                    {{ strtoupper(substr($nom, 0, 1)) }}
                </span>
            </div>
        @endif
        
        {{-- Overlay --}}
        <x-overlay-hover text="Découvrir sa page" />

        {{-- Avatar --}}
        <div class="absolute bottom-3 left-3">
            @if($artiste->photo)
                <img src="{{ asset('storage/' . $artiste->photo) }}" class="w-10 h-10 rounded-full object-cover border-2
                                        border-white shadow-md">
            @else
                <div class="w-10 h-10 rounded-full bg-[#1A1A1A] border-2
                                        border-white shadow-md flex items-center
                                        justify-center text-white text-sm font-bold">
                    {{ strtoupper(substr($nom, 0, 1)) }}
                </div>
            @endif
        </div>

        {{-- Badge art3f --}}
        @if($artiste->Est_Artiste_Art3f)
            <div class="absolute top-2 right-2 w-2 h-2 rounded-full
                                    bg-[#E8490F] shadow-md"></div>
        @endif
    </div>

    {{-- Infos --}}
    <div class="p-4">
        <h3 class="font-bold text-[#1A1A1A] truncate group-hover:text-[#E8490F]
                   transition-colors">
            {{ $nom }}
        </h3>

        @if($ville || $pays)
            <p class="text-xs text-gray-400 mt-0.5 truncate">
                {{ collect([$ville, $pays])->filter()->implode(', ') }}
            </p>
        @endif

        <div class="flex items-center justify-between mt-2">
            <p class="text-xs text-gray-400">
                {{ $nombreOeuvres }} œuvre{{ $nombreOeuvres > 1 ? 's' : '' }}
            </p>

            @if($artiste->Est_Artiste_Art3f)
                <span class="text-[10px] text-[#E8490F] font-semibold
                                         flex items-center gap-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#E8490F]"></span>
                    art3f
                </span>
            @endif
        </div>
    </div>
</a>