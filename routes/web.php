<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        return view('home');
    });

    //Ajustes
    Route::get('/ajustes', [App\Http\Controllers\AjustesController::class, 'index'])->name('ajustes');
    Route::get('/api/ajustes', [App\Http\Controllers\AjustesController::class, 'obtenerAjustes']);
    Route::post('/api/actualizarAjustes', [App\Http\Controllers\AjustesController::class, 'actualizar']);

    //Registros
    Route::resource('/api/registro', App\Http\Controllers\RegistroController::class);
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
