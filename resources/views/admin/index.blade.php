@extends('layouts.app')
@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Dashboard Admin</h1>

        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-8">
            <div class="bg-white shadow rounded-lg p-4">
                <p class="text-sm text-gray-500">Utilisateurs</p>
                <p class="text-2xl font-bold">{{ $stats['total_users'] }}</p>
            </div>
            <div class="bg-white shadow rounded-lg p-4">
                <p class="text-sm text-gray-500">Clients</p>
                <p class="text-2xl font-bold">{{ $stats['total_clients'] }}</p>
            </div>
            <div class="bg-white shadow rounded-lg p-4">
                <p class="text-sm text-gray-500">Artistes</p>
                <p class="text-2xl font-bold">{{ $stats['total_artistes'] }}</p>
            </div>
            <div class="bg-white shadow rounded-lg p-4">
                <p class="text-sm text-gray-500">Œuvres</p>
                <p class="text-2xl font-bold">{{ $stats['total_oeuvres'] }}</p>
            </div>
            <div class="bg-white shadow rounded-lg p-4">
                <p class="text-sm text-gray-500">Tirages</p>
                <p class="text-2xl font-bold">{{ $stats['total_tirages'] }}</p>
            </div>
            <div class="bg-white shadow rounded-lg p-4">
                <p class="text-sm text-gray-500">Tirages vendus</p>
                <p class="text-2xl font-bold text-[#E8490F]">{{ $stats['tirages_vendus'] }}</p>
            </div>
        </div>

        <a href="{{ route('admin.users.index') }}" class="text-[#E8490F] font-medium hover:underline">
            Voir tous les utilisateurs →
        </a>
    </div>
@endsection