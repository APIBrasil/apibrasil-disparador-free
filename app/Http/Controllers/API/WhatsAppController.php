<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as RequestGuzzle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WhatsAppController extends Controller
{
    //sendText
    public function sendText(Request $request)
    {

        $token = $request->token;
        $number = $request->number;
        $text = $request->text;

        if (empty($token) || empty($number) || empty($text)) {

            $response = [
                'status' => 'error',
                'message' => 'All fields (token, number, text) are required',
            ];

            return response()->json($response, 400);
        }

        $user = User::where('api_token', $token)->first();

        if (!$user or $user->bearer_token_api_brasil == null) {
            
            $response = [
                'status' => 'error',
                'message' => 'Invalid token',
            ];

            return response()->json($response, 401);
        }

        $client = new Client(['http_errors' => false, 'verify' => false]);
        
        $headers = [
                'Content-Type' => 'application/json',
                'Authorization' => "Bearer {$user->bearer_token_api_brasil}"
        ];
        
        $body = json_encode([
            "number" => $number,
            "text" => $text,
            "channel" => "whatsapp"
        ]);

        $request = new RequestGuzzle('POST', 'https://gateway.apibrasil.io/api/v2/bulk/direct/sendText', $headers, $body);
        $res = $client->sendAsync($request)->wait();

        $response = json_decode($res->getBody()->getContents());

        return response()->json($response, 200);
    }
}
