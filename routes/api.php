<?php

use App\Http\Controllers\API\TareaController;
use App\Http\Controllers\API\AutenticarController;
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

//Route::apiResource('tareas', TareaController::class);
Route::post('registro', [AutenticarController::class, 'registro']); //registro
Route::post('login', [AutenticarController::class, 'acceso']); //login

Route::group(['middleware' => ['auth:sanctum']], function (){
    Route::post('cerrarsesion', [AutenticarController::class, 'cerrarSesion']); //logout
    Route::apiResource('tareas', TareaController::class);
});
