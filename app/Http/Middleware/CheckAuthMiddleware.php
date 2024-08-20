<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAuthMiddleware
{
   
    public function handle(Request $request, Closure $next): Response
    {

        if(!Auth::check()) {
            return redirect('login')->with('error', 'Você precisa estar logado para acessar essa página.');
        }

        $token_cookie = Auth::user()->bearer_token_api_brasil;

        if(!$token_cookie or $token_cookie == 'null') {
            return redirect('login')->with('error', 'Seu token da APIBrasil expirou, faça login novamente.');
        }

        return $next($request);
    }

    public function getcookie($name)
    {
        return $_COOKIE[$name] ?? false;
    }
}
