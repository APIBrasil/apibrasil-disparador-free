<?php

namespace App\Http\Controllers\Admin;

use App\Models\API;
use ApiBrasil\Service;

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

        $apis = array_filter($apis, function($api) {
            return $api->type == 'whatsapp' or $api->type == 'baileys';
        });

        $servidores = array_filter($servidores, function($servidor) {
            return $servidor->type == 'whatsapp' or $servidor->type == 'baileys';
        });

        return view('admin.dispositivos')
        ->with('servidores', $servidores)
        ->with('apis', $apis)
        ->with('dispositivos', $dispositivos);
    }

    public function start(string $device_token)
    {
        try {
            
            $token = Auth::user()->bearer_token_api_brasil;

            $start = Service::WhatsApp("start", [
                "Bearer" => $token,
                "method" => "GET",
                "DeviceToken" => $device_token
            ]);
            
            return response()->json($start);

        } catch (\GuzzleHttp\Exception\RequestException $e) {

            $errorAsString = $e->getResponse()->getBody()->getContents();

            return response()->json([
                'error' => true,
                'message' => json_decode($errorAsString)
            ], 400);

        }
    }

    public function store(Request $request)
    {
        try {
            
            $token = Auth::user()->bearer_token_api_brasil;

            $store = Service::Device("store", [
                "Bearer" => $token,
                "SecretKey" => $request->secretkey,
                "body" => [
                    'type' => $request->type,
                    'device_name' => $request->device_name,
                    'device_key' => $request->device_key,
                    'device_ip' => $request->device_ip,
                    'server_search' => $request->server_search
                ]
            ]);
            
            return response()->json($store);

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
        try {
            
            $show = Service::Device("show", [
                "Bearer" => Auth::user()->bearer_token_api_brasil,
                "method" => "GET",
                "body" => [
                    "search" => $id
                ]
            ]);

            return response()->json($show);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            
            $token = Auth::user()->bearer_token_api_brasil;

            $update  = Service::Device("store", [
                "Bearer" => $token,
                "SecretKey" => $request->secretkey,
                "body" => [
                    'type' => $request->type,
                    'device_name' => $request->device_name,
                    'device_key' => $request->device_key,
                    'device_ip' => $request->device_ip,
                    'server_search' => $request->server_search
                ]
            ]);
            
            return response()->json($update);

        } catch (\GuzzleHttp\Exception\RequestException $e) {

            $errorAsString = $e->getResponse()->getBody()->getContents();

            return response()->json([
                'error' => true,
                'message' => json_decode($errorAsString)
            ], 400);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $search)
    {
        try {
            
            $token = Auth::user()->bearer_token_api_brasil;

            $delete  = Service::Device("destroy", [
                "Bearer" => $token,
                "method" => "DELETE",
                "body" => [
                    'search' => $search
                ]
            ]);

            return $delete;

        } catch (\GuzzleHttp\Exception\GuzzleException $th) {
            return response()->json(['error' => $th->getMessage()]);
        }
    }
}
