<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EstAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->user()->role !== 'admin') {
            return response()->json(['message' => 'Accès refusé. Vous devez être un administrateur pour accéder à cette ressource.'], 403);
        }
        return $next($request);
    }
}
