<?php

namespace App\Http\Controllers\Auth;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cookie;
use GuzzleHttp\Psr7\Request as RequestGuzzle;

class LoginController extends Controller
{

    public function login()
    {
        return view('login');
    }

    public function auth(Request $request): RedirectResponse
    {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        try {

            $client = new Client(['http_errors' => false, 'verify' => false]);

            $request = new RequestGuzzle('POST', 'https://gateway.apibrasil.io/api/v2/login', [
                'Content-Type' => 'application/json'
            ], json_encode($credentials));
    
            $res = $client->sendAsync($request)->wait();
            $response = json_decode($res->getBody()->getContents());

            if(isset($response->error) and $response->error) {
                return redirect('login')->with('error', $response->message);
            }

            $token = $response->authorization->token;
            Cookie::queue('token', $token, 60);
            
            return redirect('/')->with('success', $response->message);

        } catch (\GuzzleHttp\Exception\GuzzleException $th) {
            return redirect('login')->with('error', 'Erro ao tentar se conectar ao servidor de autenticação.');
        }

    }

    //logout
    public function logout(): RedirectResponse
    {
        $token = $_COOKIE['token'];

        $client = new Client(['http_errors' => false, 'verify' => false]);

        $request = new RequestGuzzle('POST', 'https://gateway.apibrasil.io/api/v2/logout', [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ]);

        $res = $client->sendAsync($request)->wait();
        $response = json_decode($res->getBody()->getContents());

        // dd($response->error);

        if(isset($response->error) and $response->error) {
            return redirect('login')->with('error', $response->message);
        }

        Cookie::queue(Cookie::forget('token'));
        return redirect('login')->with('success', 'Logout efetuado com sucesso.');

    }

}
