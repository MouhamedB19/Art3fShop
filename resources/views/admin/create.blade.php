@extends('layouts.app')
@section('content')
    <div class="max-w-md mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Créer un admin</h1>

        @if($errors->any())
            <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.users.store') }}" method="POST" class="bg-white shadow rounded-lg p-6 space-y-4">
            @csrf

            <div>
                <label class="block text-sm text-gray-500 mb-1">Nom</label>
                <x-text-input-art3f value="{{ old('nom') }}" message="Son nom" name="nom"/>
            </div>

            <div>
                <label class="block text-sm text-gray-500 mb-1">Prénom</label>
                <x-text-input-art3f value="{{ old('prenom') }}" message="Son prenom" name="prenom"/>
            </div>

            <div>
                <label class="block text-sm text-gray-500 mb-1">Email</label>
                <x-text-input-art3f value="{{ old('email') }}" message="Son adresse mail" type="email" name="email"/>
            </div>

            <div>
                <label class="block text-sm text-gray-500 mb-1">Mot de passe</label>
                <x-text-input-art3f value="{{ old('password') }}" message="Son mot de passe" type="password" name="password"/>
            </div>

            <div>
                <label class="block text-sm text-gray-500 mb-1">Confirmer le mot de passe</label>
                <x-text-input-art3f message="Confirmer le mot de passe" type="password" name="password_confirmation"/>
            </div>

            <x-grand-button-art3f label="Créer l'admin"/>
        </form>
    </div>
@endsection