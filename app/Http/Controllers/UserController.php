<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


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
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response() ->json([
            "response" => "Sesión cerrada correctamente"
        ], 200);
    }

    //Funcion para recupera contraseña mediante pregunta de seguridad
    public function resetPassword(Request $request)
    {
        // Validamos que vengan todos los campos obligatorios
        $request->validate([
            'email' => 'required|email',
            'question' => 'required|string',
            'answer' => 'required|string',
            'password' => 'required|string|min:8',
            'password_two' => 'required|string|same:password'       //Garantiza que ambas contraseñas sean iguales
        ]);
        //Buscamos el ususario por el correo electronico
        $user = User::where('email', $request->email)->first();
        if(!$user){
            return response() ->json([
                "response" => "Usuario no encontrado"
            ], 404);
        }
        //Normalizamos y comparamos respuestas (ignorandod mayusculas. minusculas y espacios extra)
        $respuestaGuardada = Str::lower(trim($user->answer));
        $respuestaIngresada = Str::lower(trim($user->answer));

        if($respuestaGuardada !== $respuestaIngresada){
            return response()->json([
                "response" => "La respuesta a la pregunta de seguridad es incorrecta"
            ], 400);
        }
        //Cambiar y encriptar la nueva contraseña
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            "response" => "Contraseña actualizada correctamente"
        ], 200);
    }

}//FIN