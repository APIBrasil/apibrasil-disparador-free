<?php

namespace App\Models;

use ApiBrasil\Service;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dispositivos extends Model
{
    use HasFactory;

    public static function getAll()
    {
        try {
            
            $token = Auth::user()->bearer_token_api_brasil;

            $all = Service::Device("", [
                "Bearer" => $token,
                "method" => "GET",
            ]);
            
            return $all;

        } catch (\GuzzleHttp\Exception\GuzzleException $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    public static function show($deviceSearch)
    {
        try {
            
            $token = Auth::user()->bearer_token_api_brasil;

            $show = Service::Device("show", [
                "Bearer" => $token,
                "method" => "GET",
                "body" => [
                    "search" => $deviceSearch
                ]
            ]);

            return $show;

        } catch (\GuzzleHttp\Exception\GuzzleException $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    public static function offline($userID)
    {
        try {
            
            $token = User::find($userID)->bearer_token_api_brasil;

            $all = Service::Device("", [
                "Bearer" => $token,
                "method" => "GET",
            ]);

            $response = array_filter($all, function($dispositivo) {
                return ($dispositivo->type == 'cellphone' or $dispositivo->type == 'tablet') and ($dispositivo->status != 'connected' and $dispositivo->status != 'open' and $dispositivo->status != 'inChat');
            });

            return $response;

        } catch (\GuzzleHttp\Exception\GuzzleException $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

    public static function online($userID)
    {
        try {
            
            $token = User::find($userID)->bearer_token_api_brasil;

            $all = Service::Device("", [
                "Bearer" => $token,
                "method" => "GET",
            ]);

            $response = array_filter($all, function($dispositivo) {
                return ($dispositivo->type == 'cellphone' or $dispositivo->type == 'tablet') and ($dispositivo->status == 'connected' or $dispositivo->status == 'open' or $dispositivo->status == 'inChat');
            });

            return $response;

        } catch (\GuzzleHttp\Exception\GuzzleException $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }

}
