<?php

namespace App\Models;

use ApiBrasil\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Servidores extends Model
{
    use HasFactory;

    public static function getAll()
    {
        try {
            
            $token = Auth::user()->bearer_token_api_brasil;

            $servers = Service::Server("", [
                "Bearer" => $token,
                "method" => "GET",
            ]);

            return $servers;

        } catch (\GuzzleHttp\Exception\GuzzleException $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }
    
}
