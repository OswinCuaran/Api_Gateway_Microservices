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
    

    // Obtener la pregunta de seguridad del usuario
    public function getSecurityQuestion(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $user = User::where('email', $request->email)->first();

        if (!$user){
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }
        return response()->json(['question' => $user->question], 200);
    }

    // Validar la respuesta y cambiar contraseña
    public function resetPassword(Request $request)
    {

    }
}