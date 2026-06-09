@extends('layouts.app')
@section('content')
    <x-guest-layout>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="mt-4">
                <x-input-label for="name" :value="__('Nom')" />
                <x-text-input-art3f id="name" class="block mt-1 w-full border" type="text" name="nom" :value="old('nom')" message="Nom" />
                <x-input-error :messages="$errors->get('nom')" class="mt-2" />
            </div>
            <!-- Prenom -->
            <div class="mt-4">
                <x-input-label for="prenom" :value="__('Prenom')" />
                <x-text-input-art3f id="prenom" class="block mt-1 w-full" type="text" name="prenom" :value="old('prenom')" message="Prénom" autofocus autocomplete="prenom" />
                <x-input-error :messages="$errors->get('prenom')" class="mt-2" />
            </div>
            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input-art3f id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" message="Email" autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Mot de passe')" />

                <x-text-input-art3f id="password" message="Mot de passe" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" />

                <x-text-input-art3f id="password_confirmation" message="Confirmer le mot de passe" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation"/>

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
            <br>
            <!-- Role -->
            <div>
                <x-input-label for="role" :value="__('Vous êtes ?')" />
                <select name="role" id="role" class="mt-1 block w-full border-[#1A1A1A] rounded-md shadow-sm">
                    <option value="acheteur">Acheteur</option>
                    <option value="artiste">Artiste</option>
                </select>
                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                    {{ __('Déjà inscrit ? Connectez-vous') }}
                </a>

                <x-primary-button class="ms-4">
                    {{ __('S\'inscrire') }}
                </x-primary-button>
            </div>
        </form>
        <button class="mt-4 w-full bg-red-500 text-white py-2 px-4 rounded-md hover:bg-red-600" onclick="window.location='{{ route('auth.google') }}'">
            {{ __('S\'inscrire avec Google') }}
        </button>
        <button class="mt-4 w-full bg-blue-600 text-white py-2
            px-4 rounded-md hover:bg-blue-700" onclick="window.location='{{ route('auth.facebook') }}'">
            {{ __('S\'inscrire avec Facebook') }}
        </button>
    </x-guest-layout>
@endsection