<?php

namespace App\Http\Controllers\Admin;

use App\Models\API;
use GuzzleHttp\Client;
use App\Models\Servidores;

use App\Models\Dispositivos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Psr7\Request as RequestGuzzle;

class DispositivosController extends Controller
{
    public function index()
    {

        $dispositivos = Dispositivos::getAll();
        $servidores = Servidores::getAll();
        $apis = API::getAll();

        $dispositivos = array_filter($dispositivos, function($dispositivo) {
            return $dispositivo->type == 'cellphone' or $dispositivo->type == 'tablet';
        });

        //apis type whatsapp or baileys
        $apis = array_filter($apis, function($api) {
            // or $api->type == 'baileys'
            return $api->type == 'whatsapp';
        });

        //server type whatsapp
        $servidores = array_filter($servidores, function($servidor) {
            return $servidor->type == 'whatsapp';
        });

        return view('admin.dispositivos')
        ->with('servidores', $servidores)
        ->with('apis', $apis)
        ->with('dispositivos', $dispositivos);
    }

    public function store(Request $request)
    {
        try {
            
            $client = new Client(['verify' => false]);

            $token = Auth::user()->bearer_token_api_brasil;

            $headers = [
                'Content-Type' => 'application/json',
                'SecretKey' => $request->secretkey,
                'Authorization' => "Bearer $token"
            ];

            $body = json_encode([
                'type' => 'cellphone',
                'device_name' => $request->device_name,
                'device_key' => $request->device_key,
                'device_ip' => $request->device_ip,
                'server_search' => $request->server_search,
                'webhook_wh_message' => $request->webhook_wh_message,
                'webhook_wh_status' => $request->webhook_wh_status
            ]); 

            $request = new RequestGuzzle('POST', 'https://gateway.apibrasil.io/api/v2/devices/store', $headers, $body);
            $res = $client->sendAsync($request)->wait();

            $response = json_decode($res->getBody()->getContents());

            return response()->json($response);

        } catch (\GuzzleHttp\Exception\RequestException $e) {

            $errorAsString = $e->getResponse()->getBody()->getContents();

            return response()->json([
                'error' => true,
                'message' => json_decode($errorAsString)
            ], 400);

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
