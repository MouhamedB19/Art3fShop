@extends('layouts.app')

@section('title', 'Mon compte')

@section('breadcrumb')
    <a href="{{ route('home') }}" class="hover:text-[#E8490F] transition-colors">Accueil</a>
    <x-mini-fleche />
    <span class="text-[#1A1A1A]">Mon compte</span>
@endsection

@section('content')
    <div class="max-w-screen-xl mx-auto px-4 py-10">

        <h1 class="text-2xl font-semibold mb-8">Mon compte</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

            {{-- Mes commandes --}}
            <a href="{{ route('compte.commandes') }}"
               class="group border border-gray-200 rounded-2xl p-6 hover:border-[#E8490F] hover:shadow-md transition-all">
                <div class="flex items-center gap-4">
                    <div class="bg-orange-50 group-hover:bg-orange-100 rounded-xl p-3 transition-colors">
                        <svg class="w-6 h-6 text-[#E8490F]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 00-1.883 2.542l.857 6a2.25 2.25 0 002.227 1.932H19.05a2.25 2.25 0 002.227-1.932l.857-6a2.25 2.25 0 00-1.883-2.542m-16.5 0V6A2.25 2.25 0 016 3.75h3.879a1.5 1.5 0 011.06.44l2.122 2.12a1.5 1.5 0 001.06.44H18A2.25 2.25 0 0120.25 9v.776" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-[#1A1A1A]">Mes commandes</p>
                        <p class="text-sm text-gray-500">Suivre mes achats</p>
                    </div>
                </div>
            </a>

            {{-- Mes conversations --}}
            <a href="{{ route('compte.conversations.index') }}"
               class="group border border-gray-200 rounded-2xl p-6 hover:border-[#E8490F] hover:shadow-md transition-all">
                <div class="flex items-center gap-4">
                    <div class="bg-orange-50 group-hover:bg-orange-100 rounded-xl p-3 transition-colors">
                        <svg class="w-6 h-6 text-[#E8490F]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-[#1A1A1A]">Mes conversations</p>
                        <p class="text-sm text-gray-500">Contacter les artistes</p>
                    </div>
                </div>
            </a>

            {{-- Mes favoris œuvres --}}
            <a href="{{ route('compte.favoris.oeuvres') }}"
               class="group border border-gray-200 rounded-2xl p-6 hover:border-[#E8490F] hover:shadow-md transition-all">
                <div class="flex items-center gap-4">
                    <div class="bg-orange-50 group-hover:bg-orange-100 rounded-xl p-3 transition-colors">
                        <svg class="w-6 h-6 text-[#E8490F]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-[#1A1A1A]">Mes favoris</p>
                        <p class="text-sm text-gray-500">Mes œuvres sauvegardées</p>
                    </div>
                </div>
            </a>

            {{-- Mes artistes favoris --}}
            <a href="{{ route('compte.favoris.artistes') }}"
               class="group border border-gray-200 rounded-2xl p-6 hover:border-[#E8490F] hover:shadow-md transition-all">
                <div class="flex items-center gap-4">
                    <div class="bg-orange-50 group-hover:bg-orange-100 rounded-xl p-3 transition-colors">
                        <svg class="w-6 h-6 text-[#E8490F]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                    </div>
                    <div>
                        <p class="font-medium text-[#1A1A1A]">Mes artistes favoris</p>
                        <p class="text-sm text-gray-500">Les artistes que je suis</p>
                    </div>
                </div>
            </a>

            
            

        </div>
    </div>
@endsection