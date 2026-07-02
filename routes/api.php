<?php
use Illuminate\Support\Facades\Route;
use App\Models\Oeuvre;

Route::get('/oeuvres', function(){
    $oeuvres = Oeuvre::all();
    return response()->json($oeuvres);
});

