<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCommentaireTerrainRequest;
use App\Http\Requests\CreateTerrainRequest;
use App\Http\Requests\EditCommentaireTerrainRequest;
use App\Models\CommentaireTerrain;
use App\Models\Maison;
use App\Models\Terrain;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentaireTerrainController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            return response()->json([
                "status_code" => 200,
                "message" => "liste des commentaires des terrains",
                "commaitaire" => CommentaireTerrain::all()
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(CreateCommentaireTerrainRequest $request, Terrain $terrain)
    {
        try {
            $commentaireTerrain = new CommentaireTerrain();
            $commentaireTerrain->users_id = auth()->user()->id;
            $commentaireTerrain->contenue = $request->contenue;
            if (Terrain::find($request->terrains_id)) {
                $commentaireTerrain->terrains_id = $request->terrains_id;
                $commentaireTerrain->save();
                return response()->json([
                    "status_code" => 200,
                    "message" => "Commentaire ajoutee",
                    "commetaire" => $commentaireTerrain
                ]);
            } else {
                return response()->json([
                    "status_code" => 404,
                    "message" => "Terrain non trouver"
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $commentaireTerrain = CommentaireTerrain::find($id);
            if (!$commentaireTerrain) {
                return response()->json([
                    "status_code" => 404,
                    "message" => "commentaire n'existe pas"
                ]);
            } else {
                return response()->json([
                    "status_code" => 200,
                    "message" => "detail commentaire du terrain",
                    "commentaire" => $commentaireTerrain
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditCommentaireTerrainRequest $request, string $id)
    {
        try {
            $commentaireTerrain = CommentaireTerrain::find($id);
            if (!$commentaireTerrain) {
                return response()->json([
                    "status_code" => 404,
                    "message" => "commentaire non trouver"
                ]);
            } else {
                $commentaireTerrain->contenue = $request->contenue;
                $commentaireTerrain->terrains_id = $request->terrains_id;
                $commentaireTerrain->save();
                return response()->json([
                    "status_code" => 200,
                    "message" => "Commentaire modifier",
                    "commentaireTerrain" => $commentaireTerrain
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $commentaireTerrain = CommentaireTerrain::find($id);
            if (!$commentaireTerrain) {
                return response()->json([
                    "status_code" => 404,
                    "message" => "commentaire non trouver"
                ]);
            } else {
                $commentaireTerrain->delete();
                return response()->json([
                    "status_code" => 200,
                    "message" => "Commentaire supprimer",
                    "commentaireTerrain" => $commentaireTerrain
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }
}
