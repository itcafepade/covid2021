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

    //Ajustes
    Route::get('/ajustes', [App\Http\Controllers\AjustesController::class, 'index'])->name('ajustes');
    Route::post('/api/actualizarAjustes', [App\Http\Controllers\AjustesController::class, 'actualizar']);

    //Registros
    Route::resource('/api/registro', App\Http\Controllers\RegistroController::class);
});

//Vista principal
Route::get('/', function () {
    return view('home');
});

Route::get('/api/ajustes', [App\Http\Controllers\AjustesController::class, 'obtenerAjustes']);
Route::get('/api/registro', [App\Http\Controllers\RegistroController::class, 'index']);
Route::post('/api/filtrarRegistro', [App\Http\Controllers\RegistroController::class, 'filtrarPorFechas']);
//Ruta disponible para la creación de nuevos registros
Route::post('/api/agregarRegistro', [App\Http\Controllers\RegistroController::class, 'store']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
