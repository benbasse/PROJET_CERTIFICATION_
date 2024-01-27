<?php

use App\Http\Controllers\api\ArticleController;
use App\Http\Controllers\api\CategorieController;
use App\Http\Controllers\api\CommentaireArticleController;
use App\Http\Controllers\api\commentaireController;
use App\Http\Controllers\api\CommentaireTerrainController;
use App\Http\Controllers\api\DemandeServiceController;
use App\Http\Controllers\api\maisonController;
use App\Http\Controllers\api\NewsLetterController;
use App\Http\Controllers\api\serviceController;
use App\Http\Controllers\api\TemoignageController;
use App\Http\Controllers\api\terrainController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Panier1Controller;
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

//new routes
Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', ['AuthController'::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);

});
//Inscription
Route::post('register', [AuthController::class, 'inscription'])->name('inscription');
//tous les routes des maisons pour les users simple
Route::get('maison/liste', [maisonController::class, 'index']);
Route::get('maison/detail/{id}', [maisonController::class, 'show']);
// les routes pour les terrains
Route::get('terrain/liste', [terrainController::class, 'index']);
Route::get('terrain/detail/{id}', [terrainController::class, 'show']);


Route::middleware(['auth:api', 'acces:user'])->group(function () {
    //commentaire pour les maisons
    Route::post('commentaire/create', [commentaireController::class, 'store']);
    Route::put('commentaire/edit/{id}', [commentaireController::class, 'update']);
    //commentaire pour les terrains
    Route::post('commentaire/terrain/create', [CommentaireTerrainController::class, 'store']);
    Route::post('service/demande/create', [DemandeServiceController::class, 'store']);
    //Pour les terrains
    Route::post('temoignage/create', [TemoignageController::class, 'store']);
    // Remplissez vos tetes et laisser vos tetes remplir vos poches
    // les commentaires pour les articles
    Route::post('commentaire/article/create', [CommentaireArticleController::class, 'store']);
    Route::get('commentaire/articleListe', [CommentaireArticleController::class, 'listeCommentaire']);
    Route::post('panier1/ajoute/maison', [Panier1Controller::class, 'store']);
    
});

// Contacter l'administrateur
Route::post('users/whatsapp', [AuthController::class, 'sendWhatsapp'])->name('whatsapp');
// les commentaires pour les maisons
Route::get('commentaire/liste', [commentaireController::class, 'index']);
Route::get('commentaire/detail/{id}', [commentaireController::class, 'show']);
// Les routes pour les services en public 
Route::get('service/liste', [serviceController::class, 'index']);
Route::get('service/detail/{id}', [serviceController::class, 'show']);
//commentaire pour les terrains
Route::get('commentaire/terrain/liste', [CommentaireTerrainController::class, 'index']);

// listes des routes pour les articles
Route::get('article/liste', [ArticleController::class, 'index']);
Route::get('article/detail/{id}', [ArticleController::class, 'show']);



Route::get('commentaire/article/liste', [CommentaireArticleController::class, 'index']);
// les routes pour les temoignage
Route::get('temoignage/liste/accepter', [TemoignageController::class, 'listeAccepter']);
//les routes pour les newsletter
Route::post('newsletter/create', [NewsLetterController::class, 'store']);


Route::get('categorie/liste', [CategorieController::class, 'index']);

Route::middleware(['auth:api', 'acces:admin'])->group(function () {
    Route::post('service/demande/refuser/{id}', [DemandeServiceController::class, 'refuserDemande']);
    Route::put('service/demande/accepter/{id}', [DemandeServiceController::class, 'accepterDemande']);
    Route::delete('service/demande/supprimer/{id}', [DemandeServiceController::class, 'deleteDemande']);
    
    Route::put('commentaire/terrain/edit/{id}', [CommentaireTerrainController::class, 'update']);
    Route::delete('commentaire/supprimer/{id}', [commentaireController::class, 'destroy']);
    // Maison
    Route::post('maison/create', [maisonController::class, 'create']);
    Route::put('maison/edit/{id}', [maisonController::class, 'update']);
    Route::delete('maison/supprimer/{id}', [maisonController::class, 'destroy']);
    //Terrain
    Route::post('terrain/create', [terrainController::class, 'store']);
    Route::put('terrain/edit/{id}', [terrainController::class, 'update']);
    Route::delete('terrain/supprimer/{id}', [terrainController::class, 'destroy']);
    //Article
    Route::post('article/create', [ArticleController::class, 'store']);
    Route::put('article/edit/{id}', [ArticleController::class, 'update']);
    Route::delete('article/supprimer/{id}', [ArticleController::class, 'destroy']);
    //Service
    Route::post('service/create', [serviceController::class, 'store']);
    Route::put('service/edit/{id}', [serviceController::class, 'update']);
    Route::delete('service/supprimer/{id}', [serviceController::class, 'destroy']);
    //Demande de services
    Route::get('service/demande/liste', [DemandeServiceController::class, 'index']);
    Route::get('service/demande/detail/{id}', [DemandeServiceController::class, 'show']);
    Route::get('service/demande/listeRefuser', [DemandeServiceController::class, 'listeDemandeRefuser']);
    Route::get('service/demande/listeAccepter', [DemandeServiceController::class, 'listeDemandeAccepter']);
    // Les routes pour les categories
    Route::post('categorie/create', [CategorieController::class, 'store']);
    Route::put('categorie/edit/{id}', [CategorieController::class, 'update']);
    Route::get('categorie/detail/{id}', [CategorieController::class, 'show']);
    Route::delete('categorie/supprimer/{id}', [CategorieController::class, 'destroy']);
    // Commentaire pour les articles
    Route::delete('commentaire/article/supprimer/{id}', [CommentaireArticleController::class, 'destroy']);
    Route::get('commentaire/article/detail/{id}', [CommentaireArticleController::class, 'show']);
    //Temoignage 
    Route::put('temoignage/refuser/{id}', [TemoignageController::class, 'refuser']);
    Route::get('temoignage/liste/enattente', [TemoignageController::class, 'listeEnAttente']);
    Route::get('temoignage/detail/{id}', [TemoignageController::class, 'show']);
    Route::get('temoignage/liste', [TemoignageController::class, 'index']);
    Route::put('temoignage/accepter/{temoignage}', [TemoignageController::class, 'accepter']);
    Route::delete('temoignage/supprimer/{id}', [TemoignageController::class, 'destroy']);
    Route::get('temoignage/liste/refuser', [TemoignageController::class, 'listeRefuser']);
    
    Route::get('newsletter/liste', [NewsLetterController::class, 'index']);
    Route::delete('newsletter/supprimer/{id}', [NewsLetterController::class, 'destroy']);
    
    Route::get('commentaire/terrain/detail/{id}', [CommentaireTerrainController::class, 'show']);
    Route::delete('commentaire/terrain/supprimer/{id}', [CommentaireTerrainController::class, 'destroy']);
});




Route::get('panier1/prixtotal/{userID}', [Panier1Controller::class, 'calculateTotalPrice']);




