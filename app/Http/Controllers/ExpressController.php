<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ExpressController extends Controller
{
    //Express
    private $token;
    public function __construct()
    {
        $this -> token = env('TOKEN');
    }

    //Endopoints de Flaks
    public function express_example(Request $request){
        $response = Http::post('http://localhost:3000/example',[
            "token" => $this -> token
        ]);
        return response() -> json($response->json());
    }
}
