<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\CommentaireArticle;
use App\Models\Maison;
use Exception;
use Illuminate\Http\Request;

class CommentaireArticleController extends Controller
{
    //

    public function index(Request $request)
    {
        try {
            $commentaireArticle = CommentaireArticle::all();
            return response()->json([
                "status_code" => 200,
                "message" => "liste des commentaire",
                "commentaire" => $commentaireArticle
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function store(Request $request)
    {
        try {
            $commentaireArticle = new CommentaireArticle();
            $commentaireArticle->contenue = $request->contenue;
            $article = Article::find($request->articles_id);
            if (!$article) {
                return response()->json([
                    "status" => 404,
                    "message" => "cette article n'existe pas"
                ]);
            } else {
                $commentaireArticle->articles_id = $article->id;
                $commentaireArticle->save();
                return response()->json([
                    "status" => 200,
                    "message" => "Commentaire ajouter"
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function show($id)
    {
        try {
            $commentaire = CommentaireArticle::find($id);
            if (!$commentaire) {
                return response()->json([
                    "status" => 404,
                    "message" => "Commentaire n'existe pas"
                ]);
            } else {
                return response()->json([
                    "status" => 200,
                    "message" => "details du commentaire",
                    "DetailsCommentaire" => $commentaire
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function destroy($id)
    {
        try {
            $commentaire = CommentaireArticle::find($id);
            if (!$commentaire) {
                return response()->json([
                    "status" => 404,
                    "message" => "Commentaire non trouver"
                ]);
            } else {
                $commentaire->delete();
                return response()->json([
                    "status" => 200,
                    "message" => "commentaire supprimer"
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function listeCommentaire(Article $article, Request $request)
    {
        try {
            $article = Article::find($request->articles_id);
            if (!$article) {
                return response()->json([
                    "status" => 404,
                    "message" => "article non trouvée"
                ]);
            }

            $commentaireArticle = CommentaireArticle::where('articles_id', $article->id)->get();
            $contenue = [];
            foreach ($commentaireArticle as $commentaire) {
                $contenue[] = $commentaire->contenue;
            }

            if ($commentaireArticle->isNotEmpty()) {
                return response()->json([
                    "status" => 200,
                    "message" => "Voici les commentaires de l'article",
                    "article" => $article->titre,
                    "contenue" => $contenue,
                    // "commentaires" => $commentaireArticle
                ]);
            } else {
                return response()->json([
                    "status" => 204,
                    "message" => "Aucun commentaire trouvé pour cette article"
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }


}
