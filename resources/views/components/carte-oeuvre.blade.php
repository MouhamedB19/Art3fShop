<div class="break-inside-avoid mb-4">

    <a href="{{ route('oeuvres.show', $oeuvre) }}"
       class="block relative group overflow-hidden rounded-xl bg-gray-100">

        <img
            src="https://images.unsplash.com/photo-1579783902614-a3fb3927b6a5?w=500"
            alt="{{ $oeuvre->titre }}"
            class="w-full h-auto object-contain transition-transform duration-500 group-hover:scale-105"
            loading="lazy">

        @if($isNew && !$vendue)
            <span class="absolute top-2 left-2 bg-black text-white text-[10px] font-bold px-2 py-0.5 rounded tracking-wider">
                NEW
            </span>
        @endif

        @if($oeuvre->taux_reduction && !$vendue)
            <span class="absolute top-2 right-2 bg-[#E8490F] text-white text-[10px] font-bold px-2 py-0.5 rounded">
                -{{ $oeuvre->taux_reduction * 100 }}%
            </span>
        @endif

        @if($vendue)
            <div class="absolute inset-0 bg-black/60 flex items-center justify-center rounded-xl">
                <span class="text-white font-black text-xl tracking-widest">
                    Vendue
                </span>
            </div>
        @endif

    </a>
    <div class="flex justify-between">
        <div class="mt-2 px-1">

           <p class="text-xs text-gray-500 truncate">
               {{ $oeuvre->artiste->nom_d_artiste ?? $oeuvre->artiste->user->nom }}

               @if($oeuvre->artiste->Est_Artiste_Art3f)
                   <span class="inline-block w-1.5 h-1.5 rounded-full bg-[#E8490F] ml-1"></span>
               @endif
           </p>

           <p class="text-sm font-semibold text-[#1A1A1A] truncate mt-0.5">
               {{ $oeuvre->titre }}
           </p>

           <p class="text-xs text-gray-400 mt-0.5">
               {{ $oeuvre->categorie->nom_categorie }}

               @if($tirage?->dimension)
                   · {{ $tirage->dimension->hauteur }}×{{ $tirage->dimension->largeur }} cm
               @endif
           </p>

           @if(!$vendue && $tirage)
               <div class="flex items-center gap-2 mt-1">

                   <span class="text-sm font-bold text-[#E8490F]">
                       {{ number_format($prixAffiche, 0, ',', ' ') }} €
                   </span>

                   @if($oeuvre->taux_reduction)
                       <span class="text-xs text-gray-400 line-through">
                           {{ number_format($prix, 0, ',', ' ') }} €
                       </span>
                   @endif

               </div>
           @endif

        </div>
        @auth
            @php
                $client = Auth::user()->client;
                $estFavoris = $client->tiragesFavoris()->where('tirage_favoris_id',$tirage->id)->exists();
            @endphp
            
            <form method="POST" action="{{ route('compte.favoris.oeuvres.handle',$tirage->id) }}" class="flex items-center mr-1" >
                @csrf
                <button type="submit">
                    <svg class="w-5 h-5 text-gray-400 group-hover:text-red-500 transition-colors"
                         fill={{ $estFavoris ? "#E8490F" : "none" }} viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke={{ $estFavoris ? "none" : "gray" }} stroke-linejoin="round" stroke-width="2"
                              d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312
                                 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0
                                 7.22 9 12 9 12s9-4.78 9-12z"/>
                    </svg>
                </button>
            </form> 
            
        @endauth
        
    </div>

</div>