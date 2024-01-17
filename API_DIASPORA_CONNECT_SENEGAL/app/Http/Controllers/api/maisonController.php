<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateMaisonRequest;
use App\Http\Requests\EditMaisonRequest;
use App\Models\Categorie;
use App\Models\Maison;
use Exception;
use Illuminate\Http\Request;

class maisonController extends Controller
{
    public function index(Maison $maison)
    {
        try {
            return response()->json([
                "status_code" => 200,
                "status_message" => "Voici la liste des maisons",
                "maison" => Maison::all(),
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function create(CreateMaisonRequest $request)
    {
        try {
            $maison = new Maison();
            $maison->addresse = $request->addresse;
            $maison->description = $request->description;
            $maison->superficie = $request->superficie;
            $maison->prix = $request->prix;
            $maison->image = $this->storeImage($request->image);
            $maison->annee_construction = $request->annee_construction;
            $maison->nombre_etage = $request->nombre_etage;
            $categorie = Categorie::find($request->categories_id);
            if (!$categorie) {
                return response()->json([
                    "status_code" => 404,
                    "status_message" => "Cette categorie n'existe pas",
                ]);
            } else {
                $maison->categories_id = $categorie->id;
            }
            $maison->save();
            return response()->json([
                'status_code' => 200,
                'status_message' => 'La maison a été ajouter',
                'maison' => $maison
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    private function storeImage($image)
    {
        return $image->store('maison', 'public');
    }

    public function show($id)
    {
        try {
            $maison = Maison::find($id);
            if (!$maison) {
                return response()->json([
                    'status_code' => 404,
                    'status_message' => 'la maison sélétionnée n\'existe pas'
                ]);
            } else {
                return response()->json([
                    "status_code" => 200,
                    "status_message" => "Voici la maison que vous avez selectionner",
                    "maison" => $maison
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function update(CreateMaisonRequest $request, $id, Maison $maison)
    {

        try {
            $maison = Maison::find($id);
            if (!$maison) {
                return response()->json([
                    "status_code" => 404,
                    "status_messages" => "Cette maison n'existe pas"
                ]);
            } else {
                $maison->addresse = $request->addresse;
                $maison->description = $request->description;
                $maison->superficie = $request->superficie;
                $maison->prix = $request->prix;
                if ($request->hasFile("image")) {
                    $maison->image = $this->storeImage($request->image);
                }
                $maison->annee_construction = $request->annee_construction;
                $maison->nombre_etage = $request->nombre_etage;
                $categorie = Categorie::find($request->categories_id);
                if (!$categorie) {
                    return response()->json([
                        "status_code" => 404,
                        "status_message" => "Cette categorie n'existe pas",
                    ]);
                } else {
                    $maison->categories_id = $categorie->id;
                }
                $maison->save();
                return response()->json([
                    "status_code" => 200,
                    "status_message" => "Vous avez modifier cette maison",
                    "maison" => $maison
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function destroy($id)
    {
        try {
            $maison = Maison::find($id);
            if (!$maison) {
                return response()->json([
                    "status_code" => 404,
                    "status_message" => "La maison que vous voulez supprimer n'existe pas"
                ]);
            } else {
                $maison->delete();
                return response()->json([
                    "status_code" => 200,
                    "status_message" => "Vous avez supprimer cette maison"
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }


}

