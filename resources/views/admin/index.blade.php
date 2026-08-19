@extends('layouts.app')
@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Dashboard Admin</h1>

        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-8">
            <x-carte-stats titre="Utilisateurs" couleur="text-gray-900" valeur="{{ $stats['total_users'] }}"/>
            <x-carte-stats titre="Clients" couleur="text-gray-900" valeur="{{ $stats['total_clients'] }}"/>
            <x-carte-stats titre="Artistes" couleur="text-gray-900" valeur="{{ $stats['total_artistes'] }}"/>
            <x-carte-stats titre="Œuvres" couleur="text-gray-900" valeur="{{ $stats['total_oeuvres'] }}"/>
            <x-carte-stats titre="Tirages" couleur="text-gray-900" valeur="{{ $stats['total_tirages'] }}"/>
            <x-carte-stats titre="Tirages vendus" couleur="text-[#1b9e09]" valeur="{{ $stats['tirages_vendus'] }}"/>
        </div>

        <a href="{{ route('admin.users.index') }}" class="text-[#E8490F] font-medium hover:underline">
            Voir tous les utilisateurs →
        </a>
    </div>
@endsection