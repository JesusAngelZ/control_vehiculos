<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\JwtMiddleware;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\VehiculoController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {

   // Route::post('login', 'App\Http\Controllers\LoginController@login');
    Route::post('login', 'App\Http\Controllers\LoginController@login');

    Route::post('loginpost', 'App\Http\Controllers\AuthController@loginpost');

    Route::post('register', 'App\Http\Controllers\AuthController@register');


    Route::get('/autos/cargar', 'App\Http\Controllers\VehiculoController@cargarDT')->name('autos.cargar');
    Route::get('/autos/{id}/edit', 'App\Http\Controllers\VehiculoController@edit')->name('autos.edit');
    //Route::get('/autos/{id}/borrar', 'App\Http\Controllers\AutoController@borrar')->name('autos.borrar');


    Route::group(['middleware' => [JwtMiddleware::class]], function () {

        //Vista principal
        Route::get('principal', 'App\Http\Controllers\LoginController@index_pricipal')->name('principal'); //http://127.0.0.1:8000/api/auth/principal

        //Acciones de Usuario
        Route::post('logout', 'App\Http\Controllers\LoginController@logout'); //Salir de sesion
        Route::post('refresh', 'App\Http\Controllers\AuthController@refresh'); //Refrescar API
        Route::post('me', 'App\Http\Controllers\AuthController@me');  //Ver informacion logeado

        //Consulta Auto
        Route::get('/autos/{id}/edit', 'App\Http\Controllers\VehiculoController@edit')->name('autos.edit');
        Route::get('auto', 'App\Http\Controllers\VehiculoController@index')->name('auto');

        //Route::get('/autos', 'App\Http\Controllers\VehiculoController@index')->name('autos.index');
        Route::get('auto_nuevo', 'App\Http\Controllers\VehiculoController@index_nuevo_auto')->name('auto_nuevo');
        Route::get('/autos/{id}', 'App\Http\Controllers\VehiculoController@show')->name('solicitud.show');

        //Actualizacion (automovil)
        Route::put('/autos/{id}', 'App\Http\Controllers\VehiculoController@update')->name('autos.update');

        //Elimniación (automovil)
        Route::delete('/autos/{id}', 'App\Http\Controllers\VehiculoController@destroy')->name('autos.borrar');

        //Ingreso (automovil)
        Route::post('auto_nuevo_store', 'App\Http\Controllers\VehiculoController@store')->name('auto_nuevo.store');

        Route::get('autos/generar-pdf/{id}', [VehiculoController::class, 'generarPdf'])->name('autos.generarPdf');



        //Solicitud
        Route::get('/solicitud/{id}', 'App\Http\Controllers\SolicitudController@show')->name('solicitud.show');

        Route::get('/verificacion/{id}', 'App\Http\Controllers\SolicitudController@verificacion')->name('solicitud.verificacion');


        // api.php
        Route::post('/solicitud-qr', [SolicitudController::class, 'createAndShowQr'])->name('solicitud.qr');

        Route::get('/solicitudes/historial', [SolicitudController::class, 'historial'])->name('solicitudes.historial');

        Route::get('/solicitudes/mi_historial', [SolicitudController::class, 'mi_historial'])->name('solicitudes.mi_historial');

        Route::put('/solicitud/{id}', [SolicitudController::class, 'update'])->name('solicitud.update');

        // Ruta para imprimir
        Route::get('/solicitud/imprimir/{id}', [SolicitudController::class, 'imprimirFormato'])->name('solicitud.imprimir');
     });

});
