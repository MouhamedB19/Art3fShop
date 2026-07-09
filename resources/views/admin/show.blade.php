@extends('layouts.app')
@section('content')
    <div class="max-w-3xl mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Détail utilisateur</h1>
            <a href="{{ route('admin.users.index') }}" class="text-gray-500 hover:underline">← Retour</a>
        </div>

        <div class="bg-white shadow rounded-lg p-6 space-y-4">
            <div>
                <p class="text-sm text-gray-500">Nom complet</p>
                <p class="font-medium">{{ $user->nom }} {{ $user->prenom }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Email</p>
                <p class="font-medium">{{ $user->email }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Rôle</p>
                <span class="px-2 py-1 text-xs rounded-full bg-gray-100">{{ $user->role }}</span>
            </div>
            <div>
                <p class="text-sm text-gray-500">Inscrit le</p>
                <p class="font-medium">{{ $user->created_at->format('d/m/Y') }}</p>
            </div>
        </div>

        <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
              onsubmit="return confirm('Supprimer cet utilisateur ?')" class="mt-6">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">
                Supprimer cet utilisateur
            </button>
        </form>
    </div>
@endsection