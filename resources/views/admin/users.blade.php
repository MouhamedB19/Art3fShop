@extends('layouts.app')
@section('content')
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Utilisateurs</h1>
            <form action="{{ route('admin.users.create') }}" method="GET">
                <x-mini-button-art3f label="+ Ajouter un admin"/>
            </form>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full bg-white shadow rounded-lg overflow-hidden">
            <thead class="bg-gray-50">
                <tr class="text-left text-sm text-gray-500">
                    <th class="px-4 py-3">Nom</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Rôle</th>
                    <th class="px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @foreach($users as $user)
                    <tr>
                        <td class="px-4 py-3">{{ $user->nom }} {{ $user->prenom }}</td>
                        <td class="px-4 py-3">{{ $user->email }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2 py-1 text-xs rounded-full bg-gray-100">{{ $user->role }}</span>
                        </td>
                        <td class="px-4 py-3 flex gap-3">
                            <a href="{{ route('admin.users.show', $user) }}" class="text-blue-600 hover:underline">Voir</a>
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                  onsubmit="return confirm('Supprimer cet utilisateur ?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Supprimer</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
@endsection

