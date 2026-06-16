@extends('layouts.app')

@section('title', 'Conversation — Commande #' . $conversation->commande_id)

@section('breadcrumb')
    <a href="{{route('home')}}" class="hover:text-[#E8490F] transition-colors">Accueil</a>
    <x-mini-fleche/>
    <a href="{{ route('compte.index') }}" class="hover:text-[#E8490F] transition-colors">Mon compte</a>
    <x-mini-fleche/>
    <a href="{{ route('compte.conversations.index') }}" class="hover:text-[#E8490F] transition-colors">
        Mes conversations
    </a>
    <x-mini-fleche/>
    <span class="text-[#1A1A1A] font-medium">Conversation sur la commande N°{{$conversation->commande_id}}</span>
        
   
@endsection

@section('content')
<div class="max-w-screen-md mx-auto px-4 py-10">
    
    {{-- En-tête --}}
    <div class="mb-6">
        <h1 class="text-xl font-semibold">Conversation — Commande #{{ $conversation->commande_id }}</h1>
        <p class="text-sm text-gray-500 mt-1">
            @if(Auth::user()->client)
                Avec <span class="font-medium">
                    @if($conversation->artiste->nom_d_artiste)
                        {{ $conversation->artiste->nom_d_artiste }}
                    @else
                        {{ $conversation->artiste->user->nom }}.{{ $conversation->artiste->user->prenom }}
                    @endif
                </span>
            @else
                Avec <span class="font-medium">{{ $conversation->client->user->nom }}.{{ $conversation->client->user->prenom }}</span>
            @endif
        </p>
    </div>

    {{-- Messages --}}
    <div class="flex flex-col gap-4 mb-8" id="messages">
        @forelse($messages as $message)
            @php 
                $isMine = $message->emetteur_id === Auth::id(); 
            @endphp
            <div class="flex {{ $isMine ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-[70%] px-4 py-3 rounded-2xl text-sm
                    {{ $isMine
                        ? 'bg-[#E8490F] text-white rounded-br-none'
                        : 'bg-gray-100 text-[#1A1A1A] rounded-bl-none' }}">
                    <p>{{ $message->contenu }}</p>
                    <p class="text-xs mt-1 {{ $isMine ? 'text-orange-200' : 'text-gray-400' }}">
                        {{ $message->created_at->format('d/m/Y à H:i') }}
                        @if($isMine && $message->lu_a)
                            · <span>Lu</span>
                        @endif
                    </p>
                </div>
            </div>
        @empty
            <p class="text-center text-gray-400 text-sm py-10">Aucun message pour l'instant.</p>
        @endforelse
    </div>

    {{-- Formulaire envoi --}}
    
    <form action="{{ route('messages.store', $conversation) }}" method="POST">
        @csrf
        <div class="flex gap-3 items-end">
            <textarea
                name="message"
                rows="3"
                placeholder="Votre message..."
                class="flex-1 border border-gray-300 rounded-xl px-4 py-3 text-sm resize-none focus:outline-none focus:ring-2 focus:ring-[#E8490F] focus:border-transparent"
                required
            ></textarea>
            <button type="submit"
                    class="bg-[#E8490F] hover:bg-[#cf3e0c] text-white text-sm font-medium px-5 py-3 rounded-xl transition-colors">
                Envoyer
            </button>
        </div>
        @error('message')
            <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
        @enderror
    </form>

</div>
@endsection

@push('scripts')
<script>
    // Scroll automatique vers le bas à l'ouverture
    const messages = document.getElementById('messages');
    if (messages) messages.lastElementChild?.scrollIntoView({ behavior: 'smooth' });
</script>
@endpush