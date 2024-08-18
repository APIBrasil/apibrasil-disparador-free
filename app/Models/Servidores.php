<?php

namespace App\Models;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use GuzzleHttp\Psr7\Request as RequestGuzzle;

class Servidores extends Model
{
    use HasFactory;

    public static function getAll()
    {
        try {
            
            $client = new Client(['http_errors' => false, 'verify' => false]);	
            $token = Auth::user()->bearer_token_api_brasil;

            $request = new RequestGuzzle('GET', 'https://gateway.apibrasil.io/api/v2/servers', [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $token
            ]);

            $res = $client->sendAsync($request)->wait();
            $response = json_decode($res->getBody()->getContents());

            return $response;

        } catch (\GuzzleHttp\Exception\GuzzleException $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }
    
}
