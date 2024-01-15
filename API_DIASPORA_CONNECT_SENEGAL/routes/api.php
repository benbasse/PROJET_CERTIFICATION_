<?php

use App\Http\Controllers\api\maisonController;
use App\Http\Controllers\api\terrainController;
use App\Http\Controllers\AuthController;
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
//new routes
Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', 'AuthController@me');
    
});

Route::post('register', [AuthController::class,'inscription'])->name('inscription');


//tous les routes pour les Maison
Route::post('maison/create', [maisonController::class,'create']);
Route::get('maison/liste', [maisonController::class,'index']);
Route::get('maison/detail/{id}', [maisonController::class,'show']);
Route::put('maison/edit/{id}', [maisonController::class,'update']);
Route::delete('maison/supprimer/{id}', [maisonController::class,'destroy']);

// les routes pour les terrains
Route::post('terrain/create', [terrainController::class,'store']);
Route::get('terrain/liste', [terrainController::class,'index']);
Route::put('terrain/edit/{id}', [terrainController::class,'update']);
Route::get('terrain/detail/{id}', [terrainController::class,'show']);
Route::delete('terrain/supprimer/{id}', [terrainController::class,'destroy']);