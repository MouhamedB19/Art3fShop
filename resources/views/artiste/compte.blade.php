@extends('layouts.app')
@section('title', "Mon espace artiste")
@section('content')
    
    <div class="max-w-screen-xl mx-auto px-4 py-10">
        <h1 class="text-2xl font-semibold mb-8">Espace artiste</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <x-box-links-page destination="{{ route('oeuvres.create') }}" label="Ajouter une oeuvre" sublabel="Mettez votre art sur le devant de la scène">
                <svg class="w-6 h-6 text-[#E8490F]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </x-box-links-page>
        </div>
    </div>
    
    

@endsection