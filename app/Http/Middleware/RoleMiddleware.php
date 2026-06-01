<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Parse roles correctly in case Laravel passes them as a single comma-separated string
        $parsedRoles = [];
        foreach ($roles as $role) {
            if (strpos($role, ',') !== false) {
                $parsedRoles = array_merge($parsedRoles, explode(',', $role));
            } elseif (strpos($role, '|') !== false) {
                $parsedRoles = array_merge($parsedRoles, explode('|', $role));
            } else {
                $parsedRoles[] = $role;
            }
        }
        
        $parsedRoles = array_map('trim', $parsedRoles);

        if (!$request->user() || !in_array($request->user()->role, $parsedRoles)) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized: Your role does not have access to this resource.',
            ], 403);
        }

        return $next($request);
    }
}
