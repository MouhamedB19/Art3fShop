<?php
use Illuminate\Support\Facades\Route;
use App\Models\Oeuvre;
use App\Http\Controllers\Api\OeuvreController;

Route::get('/oeuvres', [OeuvreController::class, 'index']);

Route::get('/oeuvres/{id}', [OeuvreController::class, 'show']);

Route::post('/oeuvres', [OeuvreController::class, 'store']);