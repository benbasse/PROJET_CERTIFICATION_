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
            $terrain->type_terrain = $request->type_terrain;
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

    private function storeImage($image)
    {
        return $image->store('terrain', 'public');
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
                    'status_code' => 404,
                    'status_message' => 'terrain n\'existe pas'
                ]);
            } else {
                $terrain->addresse = $request->addresse;
                $terrain->superficie = $request->superficie;
                $terrain->prix = $request->prix;
                $terrain->description = $request->description;
                if ($request->hasFile("image")) {
                    $terrain->image = $this->storeImage($request->image);
                } # code...
            }
            $terrain->type_terrain = $request->type_terrain;
            $terrain->save();
            return response()->json([
                "status_code" => 200,
                "status_message" => " Modification reussi",
                "terrain" => $terrain
            ]);
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
                    "status_message " => "Suppresion reussi"
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

}
