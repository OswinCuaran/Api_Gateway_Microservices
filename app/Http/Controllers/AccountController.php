<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AccountController extends Controller
{
    //Endopoints de Flaks
    public function example(Request $request){
        $response = Http::post('http://localhost:5000/example',[
            "dato" => "Mensaje enviado desde Laravel"
        ]);
        return response() -> json($response->json());
    }
}
