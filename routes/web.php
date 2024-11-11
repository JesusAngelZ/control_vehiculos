<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login.index');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

// Rutas de autenticación
Route::get('/login', [App\Http\Controllers\LoginController::class, 'index'])->name('login.form');
Route::post('/login', [App\Http\Controllers\LoginController::class, 'login'])->name('login.submit');
Route::post('/register', [App\Http\Controllers\AuthController::class, 'register'])->name('register.submit');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Route::get('/principal', 'App\Http\Controllers\LoginController@index_pricipal')->name('principal')->middleware('auth');

/*
Route::middleware('guest')->group(function () {
    Route::get('/login', [App\Http\Controllers\LoginController::class, 'index'])->name('login.form');
    Route::post('/login', [App\Http\Controllers\LoginController::class, 'login'])->name('login.submit');
});*/
