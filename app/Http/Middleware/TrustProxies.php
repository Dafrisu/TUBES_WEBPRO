<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrustProxies
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    // Ubah ini menjadi '*' untuk memercayai semua proxy (cocok untuk Railway)
    protected $proxies = '*';
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
    }
}
