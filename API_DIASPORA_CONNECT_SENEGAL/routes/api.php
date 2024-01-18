<?php

use App\Http\Controllers\api\ArticleController;
use App\Http\Controllers\api\CategorieController;
use App\Http\Controllers\api\commentaireController;
use App\Http\Controllers\api\CommentaireTerrainController;
use App\Http\Controllers\api\DemandeServiceController;
use App\Http\Controllers\api\maisonController;
use App\Http\Controllers\api\serviceController;
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
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me', [AuthController::class,'me']);
    
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



Route::middleware(['auth:api', 'acces:user'])->group(function () {
    //commentaire pour les maisons
    Route::post('commentaire/create', [commentaireController::class,'store']);
    Route::put('commentaire/edit/{id}', [commentaireController::class,'update']);
    
    //commentaire pour les terrains
    Route::post('commentaire/terrain/create', [CommentaireTerrainController::class,'store']);
    Route::put('commentaire/terrain/edit/{id}', [CommentaireTerrainController::class,'update']);
    
    Route::post('service/demande/create', [DemandeServiceController::class,'store']);
});


// les commentaires pour les maisons
Route::get('commentaire/liste', [commentaireController::class,'index']);
Route::get('commentaire/detail/{id}', [commentaireController::class,'show']);
Route::delete('commentaire/supprimer/{id}', [commentaireController::class,'destroy']);

// All the routes services
Route::get('service/liste', [serviceController::class,'index']);
Route::get('service/detail/{id}', [serviceController::class,'show']);
Route::post('service/create', [serviceController::class,'store']);
Route::put('service/edit/{id}', [serviceController::class,'update']);
Route::delete('service/supprimer/{id}', [serviceController::class,'destroy']);

//commentaire pour les terrains
Route::get('commentaire/terrain/liste', [CommentaireTerrainController::class,'index']);
Route::get('commentaire/terrain/detail/{id}', [CommentaireTerrainController::class,'show']);
Route::delete('commentaire/terrain/supprimer/{id}', [CommentaireTerrainController::class,'destroy']);

// listes des routes pour les articles
Route::get('article/liste', [ArticleController::class,'index']);
Route::get('article/detail/{id}', [ArticleController::class,'show']);
Route::post('article/create', [ArticleController::class,'store']);
Route::put('article/edit/{id}', [ArticleController::class,'update']);
Route::delete('article/supprimer/{id}', [ArticleController::class,'destroy']);


Route::middleware(['auth:api', 'acces:admin'])->group(function (){

    Route::put('service/demande/accepter/{id}', [DemandeServiceController::class,'accepterDemande']);
    Route::delete('service/demande/supprimer/{id}', [DemandeServiceController::class,'deleteDemande']);
    Route::post('service/demande/refuser/{id}', [DemandeServiceController::class,'refuserDemande']);
});

Route::get('service/demande/detail/{id}', [DemandeServiceController::class,'show']);
Route::get('service/demande/liste', [DemandeServiceController::class,'index']);
Route::get('service/demande/listeRefuser', [DemandeServiceController::class,'listeDemandeRefuser']);
Route::get('service/demande/listeAccepter', [DemandeServiceController::class,'listeDemandeAccepter']);

// Les routes pour les categories
Route::get('categorie/liste', [CategorieController::class,'index']);
Route::post('categorie/create', [CategorieController::class,'store']);
Route::put('categorie/edit/{id}', [CategorieController::class,'update']);
Route::get('categorie/detail/{id}', [CategorieController::class,'show']);
Route::delete('categorie/supprimer/{id}', [CategorieController::class,'destroy']);

// Remplissez vos tetes et laisser vos tetes remplir vos poches
