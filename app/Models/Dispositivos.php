<?php

namespace App\Models;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Psr7\Request as RequestGuzzle;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dispositivos extends Model
{
    use HasFactory;

    public static function getAll()
    {
        try {
            
            $client = new Client(['http_errors' => false, 'verify' => false]);	
            $token = Auth::user()->bearer_token_api_brasil;

            $request = new RequestGuzzle('GET', 'https://gateway.apibrasil.io/api/v2/devices', [
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

    public static function offline($id)
    {
        try {
            
            $client = new Client(['http_errors' => false, 'verify' => false]);	
            $token = User::find($id)->bearer_token_api_brasil;

            $request = new RequestGuzzle('GET', 'https://gateway.apibrasil.io/api/v2/devices', [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $token
            ]);

            $res = $client->sendAsync($request)->wait();
            $response = json_decode($res->getBody()->getContents());

            $response = array_filter($response, function($dispositivo) {
                return ($dispositivo->type == 'cellphone' or $dispositivo->type == 'tablet') and ($dispositivo->status != 'connected' or $dispositivo->status != 'open' or $dispositivo->status != 'inChat');
            });

            return $response;

        } catch (\GuzzleHttp\Exception\GuzzleException $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    public static function online($id)
    {
        try {
            
            $client = new Client(['http_errors' => false, 'verify' => false]);	
            $token = User::find($id)->bearer_token_api_brasil;

            $request = new RequestGuzzle('GET', 'https://gateway.apibrasil.io/api/v2/devices', [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $token
            ]);

            $res = $client->sendAsync($request)->wait();
            $response = json_decode($res->getBody()->getContents());

            $response = array_filter($response, function($dispositivo) {
                return ($dispositivo->type == 'cellphone' or $dispositivo->type == 'tablet') and ($dispositivo->status == 'connected' or $dispositivo->status == 'open' or $dispositivo->status == 'inChat');
            });

            return $response;

        } catch (\GuzzleHttp\Exception\GuzzleException $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    public static function getcookie($name)
    {
        return $_COOKIE[$name] ?? false;
    }

}
