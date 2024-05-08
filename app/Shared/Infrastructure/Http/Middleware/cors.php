<?php

namespace App\Shared\Infrastructure\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class cors
{
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request)
            ->header("Access-Control-Allow-Origin", "*");
    }
}
