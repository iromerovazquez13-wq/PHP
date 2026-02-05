<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route; // Agregar el controlador EventoController
use App\Http\Controllers\EventoController;


/**
* Rutas para el recurso Evento.
*/
// Recuperar todos los eventos
Route::get('/eventos', [EventoController::class, 'index']);
// Recuperar un evento específico
Route::get('/eventos/{id}', [EventoController::class, 'show']);

/**
 * Rutas provadas
 */
Route::middleware('auth:api')->group(function () {
    // Almacenar un evento nuevo
    Route::post('/eventos', [EventoController::class, 'store']);
    // Actualizar un evento específico
    Route::put('/eventos/{id}', [EventoController::class, 'update']);
    // Eliminar un evento específico
    Route::delete('/eventos/{id}', [EventoController::class, 'destroy']);
});

/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');*/
