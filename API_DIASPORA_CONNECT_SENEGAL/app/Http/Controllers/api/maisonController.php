<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateMaisonRequest;
use App\Models\Maison;
use Illuminate\Http\Request;

class maisonController extends Controller
{
    public function create(CreateMaisonRequest $request)
    {
        $maison = new Maison();
        $maison->addresse = $request->addresse;
        $maison->superficie = $request->superficie;
        $maison->prix = $request->prix;
        $maison->image = $this->storeImage($request->image);
        $maison->annee_construction = $request->annee_construction;
        $maison->nombre_etage = $request->nombre_etage;
        $maison->save();
        return response()->json([
            'status_code' => 200,
            'status_message' => 'La maison a été ajouter',
            'maison' => $maison
        ]);
    }

    private function storeImage($image)
    {
        return $image->store('maison', 'public');
    }
}
