<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


//Rutas API

//Endpoint autenticación login
Route::post('/login', [ AuthController::class, 'login']);
//Endpoint registrar un nuevo usuario
Route::post('/new', [ AuthController::class, 'new']);
// Endpoint para obtener el usuario actual
Route::get('/me', [ AuthController::class, 'me'])->middleware('auth:api');
Route::delete('/me', [ AuthController::class, 'destroy'])->middleware('auth:api');
Route::put('/me', [ AuthController::class, 'update'])->middleware('auth:api');
