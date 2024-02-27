<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateNewsletterRequest;
use App\Models\Newsletter;
use Exception;
use Illuminate\Http\Request;

class NewsLetterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $newsletters = Newsletter::all();
            return response()->json([
                "status" => 200,
                "message" => "liste des emails",
                "listeEmails" => $newsletters
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateNewsletterRequest $request)
    {
        try {
            $existingNewsletter = Newsletter::where('email', $request->email)->first(); 
            if ($existingNewsletter) {
                return response()->json([
                    "status" => "error",
                    "message" => "L'email existe déjà"
                ]);
            }   
            $newsletter = new Newsletter();
            $newsletter->email = $request->email;
            $newsletter->save();   
            return response()->json([
                "status" => "success",
                "message" => "Email ajouté"
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
        //
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
            $newsletter = Newsletter::find($id);
            $newsletter->delete();
            return response()->json([
                "status" => "success",
                "message" => "email supprimer avec success"
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }
}
