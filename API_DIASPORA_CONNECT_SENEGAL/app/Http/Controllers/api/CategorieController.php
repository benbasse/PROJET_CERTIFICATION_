<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategorieRequest;
use App\Http\Requests\EditCategorieRequest;
use App\Models\Categorie;
use Exception;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    public function index()
    {
        try {
            return response()->json([
                "status_code" => 200,
                "message" => "Listes des categories",
                "categories" => Categorie::all()
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function store(CreateCategorieRequest $request)
    {
        try {
            $categorie = new Categorie();
            $categorie->titre = $request->titre;
            $categorie->description = $request->description;
            $categorie->save();
            return response()->json([
                "status_code" => 200,
                "message" => "Categoie enregistree",
                "categorie" => $categorie
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function show($id)
    {
        try {
            $categorie = Categorie::find($id);
            if (!$categorie) {
                return response()->json([
                    "status_code" => 404,
                    "message" => "Categorie non trouvee",
                ]);
            } else {
                return response()->json([
                    "status_code" => 200,
                    "message" => "Detail de la categorie",
                    "categorie" => $categorie
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function update(EditCategorieRequest $request, $id)
    {
        try {
            $categorie = Categorie::find($id);
            if (!$categorie) {
                return response()->json([
                    "status_code" => 404,
                    "message" => "Categorie non trouvee",
                ]);
            } else {
                $categorie->titre = $request->titre;
                $categorie->description = $request->description;
                return response()->json([
                    "status_code" => 200,
                    "message" => "Categorie est modifier",
                    "categorie" => $categorie
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function destroy($id)
    {
        try {
            $categorie = Categorie::find($id);
            if (!$categorie) {
                return response()->json([
                    "status_code" => 404,
                    "message" => "Categorie non trouvee",
                ]);
            } else {
                $categorie->delete();
                return response()->json([
                    "status_code" => 200,
                    "message" => "Suppression reussi"
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }
}
