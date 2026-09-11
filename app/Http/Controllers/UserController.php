<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $user = User::create($request->all());
        return response()->json($user, 201);
    }
    
    //Funcion para el login de usuario
    public function login(Request $request)
    {
        $user = User::where('email', $request -> email)->first();
        
        if (!$user){
            return response()->json([
                "response" => "Este correo no existe"
            ], 404);
        }
        if (!Hash::check($request->password, $user->password)){
            return response()->json([
                "response" => "Credenciales incorrectas"
            ], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            "token" => $token,
            "user" => $user,
            "response" => "Bienvenido al sistema"
        ], 200);
    }

    //Funcion para el logout de usuario
    public function logout()
    {
        
    }

}//FIN