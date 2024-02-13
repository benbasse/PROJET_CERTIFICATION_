<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditUserRequest;
use App\Http\Requests\RegisterUserRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;



class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'inscription', 'index',]]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */


    public function login(LoginUserRequest $request, User $user)
    {
        $credentials = request(['email', 'password']);
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Non autorise'], 401);
        }
        $user = Auth::user();
        if ($user->est_bloquer == 0) {
            return $this->respondWithToken([$token, $user]);
        } else {
            return response()->json([
                "status" => 403,
                "message" => "Vous etes bloquer",
            ]);
        }
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 3600
        ]);
    }


    public function inscription(RegisterUserRequest $request)
    {
        try {
            $user = new User();
            $user->nom = $request->nom;
            $user->prenom = $request->prenom;
            $user->image = $this->storeImage($request->image);
            $user->telephone = $request->telephone;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();
            return response()->json([
                'status_code' => 200,
                'status_message' => 'inscription reussi'
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function UpdateUser(EditUserRequest $request, $id)
    {
        $user = User::find($id);
        if(!$user)
        {
            return response()->json([
                'status_code' => 404,
                'status_message' => 'utilisateur non trouvé',
            ]);
        } elseif ($user->role == 'user') {
            // $user->update($request->only(['nom', 'prenom', 'telephone']));
            $user->nom = $request->nom;
            $user->prenom = $request->prenom;
            $user->telephone = $request->telephone;
            $user->email = $request->email;
            $user->save();
            return response()->json([
                'status_code' => 200,
                'status_message' => 'Informations utilisateur mises à jour avec succès',
                'user' => $user,
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Impossible de modifier cet compte',
            ]);
        }
    }




    private function storeImage($image)
    {
        return $image->store('user', 'public');
    }

    public function sendWhatsapp(User $user)
    {

        try {
            // if($user->role == 'admin') {
            // $numeroWhatsApp = $user->telephone;
            $numeroWhatsApp = 772889673;
            // }
            $urlWhatsApp = "https://api.whatsapp.com/send?phone=$numeroWhatsApp";

            return redirect()->to($urlWhatsApp);
        } catch (ModelNotFoundException $e) {
            return redirect()->route('whatsapp');
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function bloquerUser($id)
    {
        try {

            $user = User::find($id);

            if ($user->role == 'user') {
                $user->est_bloquer = true;
                if ($user->update()) {
                    return response()->json([
                        "status" => 200,
                        "message" => "Utilisateur a été bloquer"
                    ]);
                }
            } else {
                return response()->json([
                    "status" => 404,
                    "message" => "Utilisateur n'existe pas"
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function debloquerUser($id)
    {
        try {
            $user = User::find($id);

            if ($user->role == 'user') {
                $user->est_bloquer = false;
                if ($user->update()) {
                    return response()->json([
                        "status" => 200,
                        "message" => "Utilisateur a été debloquer"
                    ]);
                }
            } else {
                return response()->json([
                    "status" => 404,
                    "message" => "Utilisateur n'existe pas"
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function userListBloquer()
    {
        try {
            $user = User::where('est_bloquer', true)->where('role', 'user')->get();
            if ($user) {
                return response()->json([
                    "status" => 200,
                    "message" => "Listes des utilisateur bloquer",
                    'users' => $user
                ]);
            } else {
                return response()->json([
                    "status" => 200,
                    "message" => "Pas d'utilisateur bloquer",
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }


    public function userListNonBloquer()
    {
        try {
            $user = User::where('est_bloquer', false)->where('role', 'user')->get();
            if ($user) {
                return response()->json([
                    "status" => 200,
                    "message" => "Listes des utilisateurs",
                    'users' => $user
                ]);
            } else {
                return response()->json([
                    "status" => 200,
                    "message" => "Il n'existe pas d'utilisateurs ",
                ]);
            }
        } catch (Exception $e) {
            return response()->json($e);
        }
    }

    public function index()
    {
        try {
            $user = User::where('role', 'user')->get();
            return response()->json([
                'status'=> 200,
                'message'=> 'liste des utilisateurs',
                'users'=> $user
            ]);
        } catch (Exception $e) {
            return response()->json($e);
        }
    }


}