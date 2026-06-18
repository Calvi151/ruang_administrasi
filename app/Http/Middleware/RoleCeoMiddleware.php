<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleCeoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->role === 'ceo') {
            return $next($request);
        }
        
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Unauthorized. CEO access only.'], 403);
        }
        
        abort(403, 'Unauthorized. CEO access only.');
    }
}
