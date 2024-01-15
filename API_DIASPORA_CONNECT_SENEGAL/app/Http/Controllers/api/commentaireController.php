<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCommentaireRequest;
use App\Models\Commentaire;
use App\Models\Maison;
use Exception;
use Illuminate\Http\Request;

class commentaireController extends Controller
{

    public function index()
    {
        try {
            return response()->json([
                "status_code" => 200,
                "status_message" => "liste des commentaires",
                "terrains" => Commentaire::all()
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function store(CreateCommentaireRequest $request, Maison $maison)
    {
        try {
            $commentaire = new Commentaire();
            $commentaire->users_id = auth()->user()->id;
            $commentaire->contenue = $request->contenue;
            if (Maison::find($request->maisons_id)) {
                $commentaire->maisons_id = $request->maisons_id;
                $commentaire->save();
                return response()->json([
                    "status_code" => 200,
                    "status_message" => "commentaire ajouter",
                    "commentaire" => $commentaire
                ]);
            } else {
                return response()->json([
                    "status_code" => 404,
                    "status_message" => "cette maison n'existe pas",
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function show($id)
    {
        try {
            $commentaire = Commentaire::find($id);
            if (!$commentaire) {
                return response()->json([
                    "status_code" => 404,
                    "status_message" => "cette commentaire n'existe pas"
                ]);
            } else {
                return response()->json([
                    "status_code" => 200,
                    "status_message" => "Voici le commentaire que vous avez choisi",
                    "commeatire" => $commentaire
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $commentaire = Commentaire::find($id);
            if (!$commentaire) {
                return response()->json([
                    "status_code" => 404,
                    "status_message" => "Commentaire non trouver"
                ]);
            } else {
                return response()->json([
                    "status_code" => 200,
                    "status_message" => "Vous avez modifier cette commentaire",
                    "commentaire" => $commentaire
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function destroy($id)
    {
        try {
            $commentaire = Commentaire::find($id);
            if (!$commentaire) {
                return response()->json([
                    "status_code" => 404,
                    "status_message" => "Commentaire non trouver"
                ]);
            } else {
                $commentaire->delete();
                return response()->json([
                    "status_code" => 200,
                    "status_message" => "Vous avez supprimer cette commentaire",
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }


}
