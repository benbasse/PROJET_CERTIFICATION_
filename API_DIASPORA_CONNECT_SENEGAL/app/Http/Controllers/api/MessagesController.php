<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateMessageRequest;
use App\Models\Message;
use Exception;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function index()
    {
        try {
            return response()->json([
                "status" => 200,
                "message" => "Listes des messages",
                "messages" => Message::all()
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function show($id)
    {
        try {
            $message = Message::find($id);
            if (!$message) {
                return response()->json([
                    'status_code' => 404,
                    'message' => 'message non trouver'
                ]);
            } else {
                return response()->json([
                    'status_code' => 200,
                    'message' => 'detail message',
                    'message_details' => $message
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function store(CreateMessageRequest $request)
    {
        try {
            $message = new Message();
            $message->message = $request->message;
            $message->email = $request->email;
            if ($message->save()) {
                return response()->json([
                    'status'=> 200,
                    'messages'=> 'Envoie de message reussi',
                    'message'=> $message
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function destroy($id)
    {
        try {
            $message = Message::findOrfail($id);
            if (!$message) {
                return response()->json([
                    'status' => 404,
                    'message' => 'message non trouver'
                ]);
            } else {
                $message->delete();
                return response()->json([
                    'status' => 200,
                    'message' => 'messages supprime'
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }
}
