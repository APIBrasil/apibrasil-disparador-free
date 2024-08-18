<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Psr7\Request as RequestGuzzle;
use GuzzleHttp\Client;

class API extends Model
{
    use HasFactory;

    public static function getAll()
    {
        try {
            
            $client = new Client(['http_errors' => false, 'verify' => false]);	
            $token = Auth::user()->bearer_token_api_brasil;

            $request = new RequestGuzzle('GET', 'https://gateway.apibrasil.io/api/v2/apis', [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $token
            ]);

            $res = $client->sendAsync($request)->wait();
            $response = json_decode($res->getBody()->getContents());

            return $response->apis;

        } catch (\GuzzleHttp\Exception\GuzzleException $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }
}
