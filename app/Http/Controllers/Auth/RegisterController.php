<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cookie;
use GuzzleHttp\Psr7\Request as RequestGuzzle;

class RegisterController extends Controller
{

    public function form()
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {

        try {

            $email = $request->email;
            $senha = $request->password;

            $credentials = [
                'email' => $email,
                'password' => $senha
            ];

            if (!$email || !$senha) {
                return redirect('register')->with('error', 'Você deve fornecer um email e uma senha.');
            }

            if (User::where('email', $email)->exists()) {
                return redirect('register')->with('error', "O e-mail {$email} já está em uso.");
            }

            $client = new Client(['http_errors' => false, 'verify' => false]);

            $request = new RequestGuzzle('POST', env("API_URL").'/v2/login', [
                'Content-Type' => 'application/json'
            ], json_encode($credentials));
    
            $res = $client->sendAsync($request)->wait();
            $response = json_decode($res->getBody()->getContents());

            if(isset($response->error) and $response->error) {
                return redirect('register')->with('error', "APIBrasil: {$response->message}, você precisa ter um usuário cadastrado na APIBrasil para vincular.");
            }

            if(!isset($response->authorization->token)) {
                return redirect('register')->with('error', 'Erro ao tentar se conectar ao servidor de autenticação.');
            }

            $token = $response->authorization->token;

            // Cria o usuário
            User::create([
                'name' => 'Admin',
                'email' => $email,
                'api_token' => Str::random(60),
                'password' => Hash::make($senha),
                'bearer_token_api_brasil' => $token,
                'profile_id' => $response->user->search

            ]);

            Auth::attempt($credentials);
                
            return redirect('/')->with('success', $response->message);

        } catch (\GuzzleHttp\Exception\GuzzleException $th) {
            return redirect('login')->with('error', 'Erro ao tentar se conectar ao servidor de autenticação.');
        }

    }

    //logout
    public function logout(): RedirectResponse
    {

        $token = Auth::user()->bearer_token_api_brasil;
        $client = new Client(['http_errors' => false, 'verify' => false]);

        $request = new RequestGuzzle('POST', env("API_URL").'/v2/logout', [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $token
        ]);

        $res = $client->sendAsync($request)->wait();
        $response = json_decode($res->getBody()->getContents());

        if(isset($response->error) and $response->error) {
            return redirect('login')->with('error', $response->message);
        }

        $user = User::find(Auth::id());
        $user->bearer_token_api_brasil = null;
        $user->profile_id = null;
        $user->save();

        Auth::logout();

        return redirect('login')->with('success', 'Logout efetuado com sucesso.');

    }

}
