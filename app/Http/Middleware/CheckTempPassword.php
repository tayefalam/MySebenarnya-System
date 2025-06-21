<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckTempPassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        
        // Only check for agency users
        if ($user && $user->User_Type === 'Agency') {
            $agency = $user->agency;
            
            // If agency has a temporary password, redirect to change password
            if ($agency && !empty($agency->Temp_Password) && trim($agency->Temp_Password) !== '') {
                // Allow access to the password change routes
                if (!$request->routeIs('agency.change.password') && 
                    !$request->routeIs('agency.change.password.submit') && 
                    !$request->routeIs('logout')) {
                    return redirect()->route('agency.change.password')
                        ->with('warning', 'You must change your temporary password before accessing other features.');
                }
            }
        }
        
        return $next($request);
    }
}
