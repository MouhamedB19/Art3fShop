@extends('layouts.app')

@section('title', 'Identification')

@section('content')
<div class="max-w-screen-xl mx-auto px-4 py-10">

    @include('checkout.partials.etapes', ['etape' => 'identification'])

    <div class="max-w-md mx-auto border border-gray-200 rounded-2xl p-6">
        <h1 class="text-xl font-semibold mb-6">Vos informations</h1>

        <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-12 rounded-full bg-orange-50 flex items-center justify-center text-[#E8490F] font-medium">
                {{ substr($user->prenom, 0, 1) }}{{ substr($user->nom, 0, 1) }}
            </div>
            <div>
                <p class="font-medium text-[#1A1A1A]">{{ $user->prenom }} {{ $user->nom }}</p>
                <p class="text-sm text-gray-500">{{ $user->email }}</p>
            </div>
        </div>

        <form action="{{ route('checkout.identification.store') }}" method="POST">
            @csrf
            <button type="submit" class="block w-full text-center bg-[#E8490F] text-white py-3 rounded-xl font-medium hover:bg-orange-700 transition-colors">
                Continuer
            </button>
        </form>
    </div>
</div>
@endsection