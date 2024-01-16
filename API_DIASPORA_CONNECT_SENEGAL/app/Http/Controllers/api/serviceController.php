<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateServiceRequest;
use App\Http\Requests\EditServiceRequest;
use App\Models\Service;
use Exception;
use Illuminate\Http\Request;

class serviceController extends Controller
{
    public function index(Service $service)
    {
        try {
            return response()->json([
                "status_code" => 200,
                "status_message" => "liste des services",
                "services" => Service::all(),
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function show($id)
    {
        try {
            $service = Service::find($id);
            if (!$service) {
                return response()->json([
                    "status_code" => 404,
                    "status_message" => "Service non trouver"
                ]);
            } else {
                return response()->json([
                    "status_code" => 200,
                    "status_message" => "detail service",
                    "service" => $service
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function store(CreateServiceRequest $request)
    {
        try {
            $service = new Service();
            $service->titre = $request->titre;
            $service->description = $request->description;
            $service->image = $this->storeImage($request->image);
            $service->save();
            return response()->json([
                "status_code" => 200,
                "status_message" => "Service creer avec success",
                "service" => $service,
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    private function storeImage($image)
    {
        return $image->store('service', 'public');
    }

    public function update(EditServiceRequest $request, $id)
    {
        try {
            $service = Service::find($id);
            $service->titre = $request->titre;
            $service->description = $request->description;
            if ($request->hasFile('image')) {
                $service->image = $this->storeImage($request->image);
            }
            $service->save();
            return response()->json([
                'status_code' => 200,
                'status_message' => 'Service modifier avec success',
                'service' => $service,
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function destroy($id)
    {
        try {
            $service = Service::find($id);
            if (!$service) {
                return response()->json([
                    'status_code' => '404',
                    'status_message' => 'Service non trouver',
                ]);
            } else {
                $service->delete();
                return response()->json([
                    'status_code' => 200,
                    'status_message' => 'Suppression reussi',
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }
}
