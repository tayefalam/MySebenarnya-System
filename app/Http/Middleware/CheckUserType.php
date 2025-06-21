<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CheckUserType
{
    /**
     * Handle an incoming request.
     *
     * This middleware checks if the authenticated user's User_Type
     * matches one of the allowed types passed as parameters.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed ...$types  Allowed user types (e.g. 'Public User', 'Agency', 'MCMC')
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$types)
    {
        $user = Auth::user();

        // Log for debugging
        Log::info('CheckUserType middleware triggered', [
            'path' => $request->path(),
            'authenticated' => !!$user,
            'user_data' => $user ? [
                'user_id' => $user->User_ID,
                'user_type' => $user->User_Type,
            ] : null,
            'allowed_types' => $types,
            'access_granted' => $user && in_array($user->User_Type, $types)
        ]);

        // If no user is authenticated or user type is not allowed, abort with 403
        if (!$user || !in_array($user->User_Type, $types)) {
            Log::warning('Access denied by CheckUserType middleware', [
                'path' => $request->path(),
                'user_authenticated' => !!$user,
                'user_type' => $user ? $user->User_Type : null,
                'allowed_types' => $types
            ]);
            abort(403, 'Unauthorized access.');
        }

        Log::info('Access granted by CheckUserType middleware');
        
        // User type is allowed, continue request
        return $next($request);
    }
}
