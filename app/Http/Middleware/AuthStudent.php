<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthStudent
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('auth_token') || !session()->has('user')) {
            return redirect()->route('login')->with('error', 'Iltimos, avval tizimga kiring.');
        }

        return $next($request);
    }
}