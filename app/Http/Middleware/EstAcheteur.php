<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EstAcheteur
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->user()->role !== 'acheteur') {
            return response()->json(['message' => 'Accès refusé. Vous devez être un acheteur pour accéder à cette ressource.'], 403);
        }
        return $next($request);
    }
}
