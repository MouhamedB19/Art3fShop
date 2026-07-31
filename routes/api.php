<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Oeuvre;
use App\Http\Controllers\Api\OeuvreController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\TirageController;
use App\Http\Controllers\Api\PanierController;
use App\Http\Controllers\Api\FavorisController;



Route::post('/register/artiste', [AuthController::class, 'registerArtiste']);
Route::post('register/acheteur', [AuthController::class, 'registerAcheteur']);
Route::post('/login', [AuthController::class, 'login']);





Route::get('/tirages/{id}', [TirageController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/me', [AuthController::class, 'index']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware(['auth:sanctum', 'artiste'])->group(function () {
    Route::apiResource('oeuvres', OeuvreController::class);
    Route::post('/tirages/add/oeuvre/{id}', [TirageController::class, 'addToOeuvre']);
    Route::delete('/delete/tirages/{id}', [TirageController::class, 'destroy']);
});

Route::middleware(['auth:sanctum', 'acheteur'])->group(function () {
    
    Route::get('/tirages/{id}', [TirageController::class, 'show']);


    Route::get('/panier', [PanierController::class, 'index']);
    Route::post('/panier/add/{tirageId}', [PanierController::class, 'addToPanier']);
    Route::delete('/panier/remove/{tirageId}', [PanierController::class, 'removeFromPanier']);

    
    Route::get('/favoris/tirages', [FavorisController::class, 'indexTirages']);
    Route::post('/favoris/tirages/add/{tirageId}', [FavorisController::class, 'addTirageFavoris']);
    Route::get('/favoris/artistes', [FavorisController::class, 'indexArtistes']);
    Route::post('/favoris/artistes/add/{artisteId}', [FavorisController::class, 'addArtistes']);
    
});

Route::middleware(['auth:sanctum', 'admin'])->group(function () {

    Route::post('/register/admin', [AdminController::class, 'registerAdmin']);

    Route::delete('/destroy/user/{id}', [AdminController::class, 'destroyUser']);

    Route::get('/users', [AdminController::class, 'getAllUsers']);

    Route::get('/user/{id}', [AdminController::class, 'getUserById']);

    Route::get('/admin/stats', [AdminController::class, 'statsArt3fShop']);
});

