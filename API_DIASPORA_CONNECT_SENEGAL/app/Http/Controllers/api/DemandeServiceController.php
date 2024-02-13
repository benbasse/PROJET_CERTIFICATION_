<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateDemandeServiceRequest;
use App\Models\Demande_service;
use App\Models\Service;
use Illuminate\Http\Request;
use Exception;

class DemandeServiceController extends Controller
{
    public function index()
    {
        return response()->json([
            "status_code" => 200,
            "status_message" => "liste des demandes",
            "demandes" => Demande_service::with('Service', 'User')->get()
        ]);
    }

    public function store(CreateDemandeServiceRequest $request)
    {
        try {
            $demande_service = new Demande_service();
            $demande_service->users_id = auth()->user()->id;
            $service = Service::find($request->services_id);
            if ($service) {
                $demande_service->services_id = $service->id;
            } else {
                return response()->json([
                    'status' => 404,
                    'message'=> "service n'existe pas"
                ]);
            }
            $demande_service->save();
            return response()->json([
                "status_code" => 200,
                "status_message" => "Demande enregistrer",
                "demande_service" => $demande_service
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function show($id)
    {
        try {
            $demande_service = Demande_service::find($id);
            if (!$demande_service) {
                return response()->json([
                    "status_code" => 404,
                    "status_message" => "demande inexistante",
                ]);
            } else {
                return response()->json([
                    "status_code" => 200,
                    "status_message" => "detail de la demande",
                    "demande_detail" => $demande_service
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function accepterDemande(Request $request, $id)
    {
        try {
            $demande_service = Demande_service::find($id);
            if (!$demande_service) {
                return response()->json([
                    "status_code" => 404,
                    "status_message" => "Demande inexistante",
                ]);
            } else {
                $demande_service->update([
                    "est_accepter" => 1
                ]);
                $demande_service->save();
                return response()->json([
                    "status_code" => 200,
                    "status_message" => "Demande accepter",
                    "demande_service" => $demande_service
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function refuserDemande($id)
    {
        try {
            $demande_service = Demande_service::find($id);
            // dd($demande_service);
            $demande_service->update([
                "est_accepter" => 0
            ]);
            $demande_service->save();
            return response()->json([
                "status_code" => 200,
                "status_message" => "Demande refuser",
                "demande_service" => $demande_service
            ]);
            // if (!$demande_service) {
            //     return response()->json([
            //         "status_code" => 404,
            //         "status_message" => "Demande inexistante",
            //     ]);
            // } else {
            //     $demande_service->update([
            //         "est_accepter" => 0
            //     ]);
            //     $demande_service->save();
            //     return response()->json([
            //         "status_code" => 200,
            //         "status_message" => "Demande refuser",
            //         "demande_service" => $demande_service
            //     ]);
            // }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function deleteDemande(Request $request, $id)
    {
        $demande_service = Demande_service::find($id);
        if (!$demande_service) {
            return response()->json([
                "status_code" => 404,
                "status_message" => "demande non trouvee",
            ]);
        } else {
            $demande_service->delete();
            return response()->json([
                "status_code" => 200,
                "status_message" => "Vous avez supprimer la demande",
            ]);
        }
    }

    public function listeDemandeAccepter()
    {
        try {
            $demande_service = Demande_service::where('est_accepter', 1)->get();
            if (!empty($demande_service)) {
                return response()->json([
                    'status_code' => 404,
                    'status_message' => 'Pas de demande accepeter',
                ]);
            } else {
                return response()->json([
                    "status_code" => 200,
                    "demandes" => $demande_service
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }


    public function listeDemandeRefuser()
    {
        try {
            return response()->json([
                "status_code" => 200,
                "messages"=> " listes des demandes refusées",
                "demandes" => Demande_service::where('est_accepter', 0)->get()
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

}
