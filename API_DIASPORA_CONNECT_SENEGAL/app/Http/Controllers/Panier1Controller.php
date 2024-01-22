<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePanier1Request;
use App\Http\Requests\UpdatePanier1Request;
use App\Models\Maison;
use App\Models\Panier1;
use Exception;

class Panier1Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StorePanier1Request $request)
    {
        try {
            $panier1 = new Panier1();
            $panier1->users_id = auth()->user()->id;
            $maison = Maison::find($request->maisons_id);
            if (!$maison) {
                return response()->json([
                    "error" => "404",
                    "message" => "maison non trouve"
                ]);
            }
            $panierExist = Panier1::where('users_id', $panier1->users_id)
                ->where('maisons_id', $maison->id)
                ->exists();

            if ($panierExist) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Cette maison est deja dans la panier'
                ]);
            }

            $panier1->maisons_id = $maison->id;
            if ($panier1->save()) {
                return response()->json([
                    "status_code" => 200,
                    "message" => "ajout au panier reussi",
                    "panier1" => $panier1
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Panier1 $panier1)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Panier1 $panier1)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePanier1Request $request, Panier1 $panier1)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Panier1 $panier1)
    {
        //
    }
    private $prixMaison;
    public function TotalPrix(Panier1 $panier1, Maison $maison)
    {
        $liste = Panier1::all();
        $listeMaison[] = $liste->maisons_id;
        foreach ($listeMaison as $maison) {
            foreach ($maison as $maison) {
                $maison->prix = $this->prixMaison;
            }
        }
    }

    public function calculateTotalPrice($userId)
    {
        $totalPrice = Panier1::join('maisons', 'panier1.maisons_id', '=', 'maisons.id')
            ->where('panier1.users_id', $userId)
            ->sum('maisons.prix');

        return response()->json([
            "status_code" => 200,
            "message" => "Total calculé avec succès",
            "total_price" => $totalPrice
        ]);
    }

}
