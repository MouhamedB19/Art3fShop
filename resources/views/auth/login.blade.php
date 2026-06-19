@extends('layouts.app')
@section('content')
    <x-guest-layout>
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />
    
        <form method="POST" action="{{ route('login') }}">
        @csrf

            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input-art3f id="email" type="email" name="email" value="{{ old('email') }}" message="Votre adresse mail" required autocomplete="username"/>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
        
            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Mot de passe')" />
            
                <x-text-input-art3f id="password" 
                                type="password"
                                name="password"
                                value="{{ old('password') }}"
                                message="Mot de passe"
                                required autocomplete="current-password" />
            
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
        
            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="w-4 h-4 rounded border-gray-300 accent-[#E8490F]" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                </label>
            </div>
        
            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('register') }}">
                    {{ __('Pas de compte ? Créez-en un') }}
                </a>
                <x-primary-button class="ms-3">
                    {{ __('Log in') }}
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