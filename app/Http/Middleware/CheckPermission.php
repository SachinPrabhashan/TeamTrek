<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // public function handle(Request $request, Closure $next): Response
    // {
    //     return $next($request);
    // }

    public function handle($request, Closure $next, $moduleName, $permissionName)
    {
        $user = auth()->user();

        if (!$user->hasPermission($moduleName, $permissionName)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
