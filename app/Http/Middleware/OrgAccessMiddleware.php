<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OrgAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $user = auth()->user();

        if ($user->role === 'super_admin') {
            return $next($request);
        }

        // org users only see their own org data
        $request->merge(['org_id' => $user->org_id]);

        return $next($request);
    }
}
