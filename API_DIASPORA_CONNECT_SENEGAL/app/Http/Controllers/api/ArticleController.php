<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateArticleRequest;
use App\Http\Requests\EditArticleRequest;
use App\Models\Article;
use Exception;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        try {
            return response()->json([
                "status_code" => 200,
                "message" => "Listes des articles",
                "articles" => Article::all()
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function store(CreateArticleRequest $request)
    {
        try {
            $article = new Article();
            $article->titre = $request->titre;
            $article->description = $request->description;
            $article->image = $this->storeImage($request->image);
            $article->save();
            return response()->json([
                "status_code" => 200,
                "message" => "article creer",
                "article" => $article
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    private function storeImage($image)
    {
        return $image->store('article', 'public');
    }

    public function show($id)
    {
        try {
            $article = Article::find($id);
            if (!$article) {
                return response()->json([
                    'status_code' => 404,
                    'message' => 'article non trouver'
                ]);
            } else {
                return response()->json([
                    'status_code' => 200,
                    'message' => 'detail article',
                    'article' => $article
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function update(EditArticleRequest $request, $id)
    {
        try {
            $article = Article::find($id);
            if (!$article) {
                return response()->json([
                    'status_code' => 404,
                    'message' => 'article n\'existe pas'
                ]);
            } else {
                $article->titre = $request->titre;
                $article->description = $request->description;
                if ($request->hasFile('image')) {
                    $article->image = $this->storeImage($request->image);
                } 
                $article->save();
                return response()->json([
                    'status_code' => 200,
                    'message' => 'modification réussi',
                    'article' => $article
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function destroy($id)
    {
        try {
            $article = Article::find($id);
            if (!$article) {
                return response()->json([
                    'status' => 404,
                    'message' => 'article non trouver'
                ]);
            } else {
                $article->delete();
                return response()->json([
                    'status' => 200,
                    'message' => 'article supprimer',
                    'article' => $article
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

}
