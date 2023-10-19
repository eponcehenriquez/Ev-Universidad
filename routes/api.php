<?php

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


//Rutas API

//Endpoint autenticación login
Route::post('/login', 'AuthController@login');
//Endpoint registrar un nuevo usuario
Route::post('/new', 'AuthController@register');
// Grupo de rutas que requieren autenticación de la API
Route::middleware('auth:api')->group(function () {
    // Endpoint para obtener la información de perfil
    Route::get('/me', 'AuthController@me');
});