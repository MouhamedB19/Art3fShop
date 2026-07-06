<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Oeuvre;
use App\Http\Controllers\Api\OeuvreController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\AdminController; 

Route::get('/oeuvres', [OeuvreController::class, 'index']);

Route::get('/oeuvres/{id}', [OeuvreController::class, 'show']);

Route::post('/oeuvres', [OeuvreController::class, 'store']);

Route::put('/oeuvres/{id}', [OeuvreController::class, 'update']);

Route::delete('/oeuvres/{id}', [OeuvreController::class, 'destroy']);


Route::post('/register/artiste', [AuthController::class, 'registerArtiste']);
Route::post('register/acheteur', [AuthController::class, 'registerAcheteur']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('oeuvres', OeuvreController::class);
    Route::get('/user', [AuthController::class, 'index']);
});

Route::middleware(['auth:sanctum','admin'])->group(function () {

    Route::apiResource('oeuvres', OeuvreController::class);

    Route::post('/register/admin',[AdminController::class, 'registerAdmin']);

    Route::delete('/destroy/user/{id}', [AdminController::class, 'destroyUser']);

    Route::get('/users', [AdminController::class, 'getAllUsers']);

    Route::get('/users/{id}', [AdminController::class, 'getUserById']);

    Route::get('/admin/stats', [AdminController::class, 'statsArt3fShop']);
});
