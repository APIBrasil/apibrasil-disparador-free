<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAuthMiddleware
{
   
    public function handle(Request $request, Closure $next): Response
    {

        $token_cookie = $this->getcookie('token');

        if(!$token_cookie) {
            return redirect('login');
        }

        return $next($request);
    }

    public function getcookie($name)
    {
        return $_COOKIE[$name] ?? false;
    }
}
