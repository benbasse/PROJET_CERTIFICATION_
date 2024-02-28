<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTerrainRequest;
use App\Http\Requests\EditTerrainRequest;
use App\Models\Terrain;
use Exception;
use Illuminate\Http\Request;

class terrainController extends Controller
{
    public function index()
    {
        try {
            return response()->json([
                "status_code" => 200,
                "status_message" => "liste des terrains",
                "terrains" => Terrain::all()
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function store(CreateTerrainRequest $request)
    {
        try {
            $terrain = new Terrain();
            $terrain->addresse = $request->addresse;
            $terrain->superficie = $request->superficie;
            $terrain->prix = $request->prix;
            $terrain->description = $request->description;
            $terrain->image = $this->storeImage($request->image);
            // $terrain->type_terrain = $request->type_terrain;
            $terrain->save();
            return response()->json([
                "status_code" => 200,
                "status_message" => "Ajout terrain est reussi",
                "terrain" => $terrain
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }


    public function show($id)
    {
        try {
            $terrain = Terrain::find($id);
            if (!$terrain) {
                return response()->json([
                    'status_code' => 404,
                    'status_message' => 'terrain n\'existe pas'
                ]);
            } else {
                return response()->json([
                    "status_code" => 200,
                    "status_message" => "voici le detail du terrain",
                    "terrain" => $terrain
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }


    public function update(EditTerrainRequest $request, $id)
    {
        try {
            $terrain = Terrain::find($id);
            if (!$terrain) {
                return response()->json([
                    "status_code" => 404,
                    "status_messages" => "Cet terrain n'existe pas"
                ]);
             } else {
            $terrain->addresse = $request->addresse;
            $terrain->superficie = $request->superficie;
            $terrain->prix = $request->prix;
            $terrain->description = $request->description;
            if ($request->hasFile("image")) {
                $terrain->image = $this->storeImage($request->image);
            }
            // $terrain->image = $this->storeImage($request->image);
            // $terrain->type_terrain = $request->type_terrain;
            $terrain->update();
            return response()->json([
                "status_code" => 200,
                "status_message" => " Modification reussi",
                "terrain" => $terrain
            ]);
        }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function destroy($id)
    {
        try {
            $terrain = Terrain::find($id);
            if (!$terrain) {
                return response()->json([
                    "statys_code" => 404,
                    "status_message" => "Terrain non trouve ",
                ]);
            } else {
                $terrain->delete();
                return response()->json([
                    "status_code" => 200,
                    "status_message " => "Suppression reussi"
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }
    private function storeImage($image)
    {
        return $image->store('terrain', 'public');
    }


    // les nouvelles fonctionnalites

    public function Acheter(Terrain $terrain)
    {
        try {
            $terrain = Terrain::where('est_acheter',true)->get();
            if ($terrain->isEmpty()) {
                return response()->json([
                    "status" => 200,
                    "message" => "Pas de terrain acheter pour le moment",
                ]);
            } else {
                return response()->json([
                    "status" => 200,
                    "message" => "Voici la liste des terrains achetes",
                    "terrain" => $terrain,
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function NonAcheter(Terrain $terrain)
    {
        try {
            $terrain = Terrain::where('est_acheter',false)->get();
            if ($terrain->isEmpty()) {
                return response()->json([
                    "status" => 200,
                    "message" => "Tous les terrains ont ete vendu",
                ]);
            } else {
                return response()->json([
                    "status" => 200,
                    "message" => "Voici la liste des terrains non acheter",
                    "terrain" => $terrain,
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function Vendre($id)
    {
        try {
            $terrain = Terrain::find($id);
            if ($terrain) {
                $terrain->update([
                    'est_acheter' => 1
                ]);
                return response()->json([
                    "status" => 201,
                    "message" => "Terrain vendu",
                ]);
            } else {
                return response()->json([
                    "status" => 404,
                    "message" => "Cette terrain n'existe pas",
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function NonVendre($id)
    {
        try {
            $terrain = Terrain::find($id);
            if ($terrain) {
                $terrain->update([
                    'est_acheter' => 0
                ]);
                return response()->json([
                    "status" => 201,
                    "message" => "Vente rejeter",
                ]);
            } else {
                return response()->json([
                    "status" => 404,
                    "message" => "Cette terrain n'existe pas",
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

}
