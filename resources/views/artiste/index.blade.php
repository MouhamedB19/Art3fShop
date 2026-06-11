@extends('layouts.app')
@section('title', 'Index — Tous nos artistes')
@section('breadcrumb')
    <nav class="max-w-screen-xl  px-4 py-3 flex items-center gap-2 text-xs text-gray-500">
        <a href="{{ route('home') }}" class="hover:text-[#E8490F] transition-colors">Accueil</a>
        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
        <span class="text-[#1A1A1A] font-medium">Artistes</span>
   </nav>
@endsection
@section('content')
    
    <livewire:artistes-filtres />
@endsection