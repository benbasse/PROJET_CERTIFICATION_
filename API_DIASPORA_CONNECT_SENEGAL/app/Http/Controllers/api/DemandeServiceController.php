<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Demande_service;
use Illuminate\Http\Request;

class DemandeServiceController extends Controller
{
    public function index()
    {
        return response()->json([
            "status_code" => 200,
            "demandes"=> Demande_service::all()
        ]);
    }
}
