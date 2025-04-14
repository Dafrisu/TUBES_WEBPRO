<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class IdleTimeoutMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $lastActivity = Session::get('last_activity');
            $timeout = 15; // Waktu idle dalam detik

            if ($lastActivity && (time() - $lastActivity > $timeout)) {
                Auth::logout(); // Logout user
                Session::flush();
                return redirect('/masuk')->withErrors(['message' => 'Session expired due to inactivity.']);
            }

            Session::put('last_activity', time()); // Reset timer
        }
        return $next($request);
    }
}
