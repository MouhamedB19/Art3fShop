@extends('layouts.app')

@section('title', 'Catalogue — Toutes les œuvres')

@section('content')
    {{ Breadscrumbs::render('catalogue',$categorie) }}
    <livewire:catalogue-filtres />
@endsection