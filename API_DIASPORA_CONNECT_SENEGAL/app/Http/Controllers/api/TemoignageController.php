<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTemoignageRequest;
use App\Models\Temoignage;
use Exception;
use Illuminate\Http\Request;

class TemoignageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $temoignage = Temoignage::all();
            return response()->json([
                "status" => 200,
                "message" => "Liste des temoignage",
                "temoignages" => $temoignage
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateTemoignageRequest $request)
    {
        try {
            $temoignage = new Temoignage();
            $temoignage->users_id = auth()->user()->id;
            $temoignage->contenue = $request->contenue;
            $temoignage->save();
            return response()->json([
                "stasus" => 200,
                "message" => "Temoignage ajouter avec success",
                "temoignage" => $temoignage
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $temoignage = Temoignage::find($id);
            if (!$temoignage) {
                return response()->json([
                    "status" => 404,
                    "message" => "temoignage non trouver"
                ]);
            } else {

                return response()->json([
                    "status" => 200,
                    "message" => "detail du temoignage",
                    "temoignage" => $temoignage
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $temoignage = Temoignage::find($id);
            if (!$temoignage) {
                return response()->json([
                    "status" => 404,
                    "message" => "temoignage non trouver"
                ]);
            } else {
                $temoignage->delete();
                return response()->json([
                    "status" => 200,
                    "message" => "temoignage supprimer"
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function listeEnAttente()
    {
        try {
            $temoignage = Temoignage::where('statut', 'attente')->get();
            if ($temoignage) {
                return response()->json([
                    "status" => 200,
                    "message" => "Liste des temoignage en attente",
                    "temoignages" => $temoignage
                ]);
            } else {
                return response()->json([
                    "status" => 404,
                    "message" => "Pas de temoignage en attente"
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function listeAccepter()
    {
        try {
            $temoignage = Temoignage::where('statut', 'accepter')->get();
            if ($temoignage) {
                return response()->json([
                    "status" => 200,
                    "message" => "Liste des temoignage accepter",
                    "temoignages" => $temoignage
                ]);
            } else {
                return response()->json([
                    "status" => 404,
                    "message" => "Pas de temoignage accepter"
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function listeRefuser()
    {
        try {
            $temoignage = Temoignage::where('statut', 'refuser')->get();
            if ($temoignage) {
                return response()->json([
                    "status" => 200,
                    "message" => "Liste des temoignage refuser",
                    "temoignages" => $temoignage
                ]);
            } else {
                return response()->json([
                    "status" => 404,
                    "message" => "Pas de temoignage refuser"
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function accepter($id)
    {
        try {
            $temoignage = Temoignage::find($id);
            if (!$temoignage) {
                return response()->json([
                    "status" => 404,
                    "message" => "Temoignage non trouver"
                ]);
            }
            if ($temoignage->statut = 'accepter') {
                $temoignage->save();
                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'Vous avez accepter cette temoignage',
                ]);

            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'acceptation echouer'
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function refuser($id)
    {
        try {
            $temoignage = Temoignage::find($id);
            if (!$temoignage) {
                return response()->json([
                    "status" => 404,
                    "message" => "Temoignage non trouver"
                ]);
            }
            if ($temoignage->statut = 'refuser') {
                $temoignage->save();
                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'Vous avez refuser cette temoignage',
                ]);

            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'refus echouer'
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function MyTemoignageAttente()
    {
        try {
            if (auth()->user()) {
                $temoignage = Temoignage::where('users_id', auth()->user()->id)
                    ->where('statut', 'attente')->get();
            }
            if ($temoignage->isEmpty()) {
                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'Pas de temoignage en attente',
                ]);
            } else {
                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'liste de mes temoignages en attente',
                    'temoignages' => $temoignage
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function MyTemoignageAccepter()
    {
        try {
            if (auth()->user()) {
                $temoignage = Temoignage::where('users_id', auth()->user()->id)
                    ->where('statut', 'accepter')->get();
            }
            if ($temoignage->isEmpty()) {
                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'Pas de temoignage accepter',
                ]);
            } else {
                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'liste de mes temoignages accepter',
                    'temoignages' => $temoignage
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function MyTemoignageRefuser()
    {
        try {
            if (auth()->user()) {
                $temoignage = Temoignage::where('users_id', auth()->user()->id)
                    ->where('statut', 'refuser')->get();
            }
            if ($temoignage->isEmpty()) {
                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'Pas de temoignage refuser',
                ]);
            } else {
                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'liste de mes temoignages refuser',
                    'temoignages' => $temoignage
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

}
