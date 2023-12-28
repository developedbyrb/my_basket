<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckPermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission, $isAllowToAdmin = true): Response
    {
        $isAllowToAdmin = filter_var($isAllowToAdmin, FILTER_VALIDATE_BOOLEAN);
        $user = auth()->user();

        if ($user && $user->role) {
            if ($user->role->hasPermission($permission) || ($isAllowToAdmin && $user->hasRole('admin'))) {
                return $next($request);
            } else {
                Log::info("User does not have permission: {$permission}");
            }
        } else {
            Log::warning("User or role not found for user ID: {$user->id}");
        }

        abort(403, 'Unauthorized');
    }
}
