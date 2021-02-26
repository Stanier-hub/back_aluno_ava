<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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
Route::group(['prefix' => 'v1'], function ($router) {


    // rotas para login
    Route::group([
        'prefix' => 'logar'
    
    ], function ($router) {
    
        Route::get('/', function () {
            return view('welcome');
        });
        
    
    });


    // rotas para listar permissoes
    Route::group([
        'prefix' => 'permissoes'
    
    ], function ($router) {
    
        Route::post('/login', [AuthController::class, 'login']);
        
    
    });


    // rotas para Setor de matriculas
    Route::group([
        'prefix' => 'matriculas'
    
    ], function ($router) {
    
        Route::post('/login', [AuthController::class, 'login']);
        
    
    });

    // rotas para Setor de financeiro
    Route::group([
        'prefix' => 'financeiro'
    
    ], function ($router) {
    
        Route::post('login', [AuthController::class, 'login']);
        
    
    });

    // rotas para Setor de Secretaria
    Route::group([
        'prefix' => 'Secretaria'
    
    ], function ($router) {
    
        Route::post('login', [AuthController::class, 'login']);
        
    
    });


    // rotas para Setor de Secretaria
    Route::group([
        'prefix' => 'rh'
    
    ], function ($router) {
    
        Route::post('login', [AuthController::class, 'login']);
        
    
    });



});

Route::get('/', function () {
    return view('welcome');
});



//     Route::post('login', [AuthController::class, 'login']);
//     Route::post('logout',[AuthController::class, 'logout']);
//     Route::post('refresh',[AuthController::class, 'refresh']);
//     Route::post('me', [AuthController::class, 'me']);