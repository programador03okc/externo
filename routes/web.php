<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ExportarProformaController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Artisan;
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
Route::get('artisan', function () {
    Artisan::call('clear-compiled');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('route:clear');
});

Route::get('/dashboard', [HomeController::class, 'index'])->middleware('auth')->name('home');
Route::get('/', [HomeController::class, 'index'])->middleware('auth')->name('home');

Route::name('proformas.')->prefix('proformas')->middleware('auth')->group(function () { //Route::group(['as' => 'mgcp.', 'prefix' => 'mgcp'], function () {
    Route::name('exportar.')->prefix('exportar')->group(function () {
        Route::get('index', [ExportarProformaController::class,'index'])->name('index');
        Route::post('generar-archivo', [ExportarProformaController::class, 'generarArchivo'])->name('generar-archivo');
    });
    
});

Route::name('usuario.')->prefix('usuario')->middleware('auth')->group(function () { //Route::group(['as' => 'mgcp.', 'prefix' => 'mgcp'], function () {
    Route::get('cerrar-sesion', [UsuarioController::class,'cerrarSesion'])->name('cerrar-sesion');
});


require __DIR__.'/auth.php';
