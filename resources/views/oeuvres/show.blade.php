@extends('layouts.app')

@section('title', $oeuvre->titre)

@section('content')
    <div class="max-w-screen-xl mx-auto px-4 py-12">
        <h1 class="text-3xl font-black">{{ $oeuvre->titre }}</h1>
        <p class="text-gray-500 mt-2">Page en cours de développement — S3</p>
    </div>
@endsection