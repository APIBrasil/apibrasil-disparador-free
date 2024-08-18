<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
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
        return view('auth.login');
    }

    public function auth(Request $request): RedirectResponse
    {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        //login
        if (Auth::attempt($credentials)) {

            try {

                $client = new Client(['http_errors' => false, 'verify' => false]);
    
                $request = new RequestGuzzle('POST', env("API_URL").'/v2/login', [
                    'Content-Type' => 'application/json'
                ], json_encode($credentials));
        
                $res = $client->sendAsync($request)->wait();
                $response = json_decode($res->getBody()->getContents());
    
                if(isset($response->error) and $response->error) {
                    return redirect('login')->with('error', $response->message);
                }
    
                $token = $response->authorization->token;

                $user = User::find(Auth::id());
                $user->bearer_token_api_brasil = $token;
                $user->profile_id = $response->user->search;

                $user->save();
    
                return redirect('/')->with('success', $response->message);
    
            } catch (\GuzzleHttp\Exception\GuzzleException $th) {
                return redirect('login')->with('error', 'Erro ao tentar se conectar ao servidor de autenticação.');
            }

            $request->session()->regenerate();
            return redirect()->intended('/');

        }else{
            return back()->with('error', 'Credenciais inválidas.');
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
