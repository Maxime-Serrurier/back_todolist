<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Retourne la liste des tâches au format json
Route::get('/tasks', [TaskController::class, 'list']);

// Retourne une tâche au format json
Route::get('/tasks/{id}', [TaskController::class, 'read']);

// Création d'une nouvelle tâche
Route::post('/tasks', [TaskController::class, 'create']);

// Mise à jour d'une tâche
Route::put('/tasks/{id}', [TaskController::class, 'update']);

// Suppression d'une tâche
Route::delete('/tasks/{id}', [TaskController::class, 'delete']);

// Inscription d'un utilisateur
Route::post('/inscription', [UserController::class, 'register']);

// Connexion d'un utilisateur
Route::post('/connexion', [UserController::class, 'login']);

// Déconnexion d'un utilisateur
Route::post('/deconnexion', [UserController::class, 'logout']);
