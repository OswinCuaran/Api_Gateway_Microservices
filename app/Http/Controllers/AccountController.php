<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AccountController extends Controller
{
    private $token;
    public function __construct()
    {
        $this -> token = env('TOKEN');
    }

    //Endopoints de Flaks
    public function example(Request $request){
        $response = Http::post('http://localhost:5000/example',[
            "token" => $this -> token
            //"dato"  => $request->input('el_dato')
        ]);
        return response() -> json($response->json());
    }
}
