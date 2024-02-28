<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class validateUse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            if(!Auth::user()->is_email_verified){
                 
                 return response()->json([
                    'status' => false,
                    'message' => 'notemailverfied',
                    ], 401);
            }
            if(!Auth::user()->is_mobile_verified){
                 
                 return response()->json([
                    'status' => false,
                    'message' => 'notmobileverfied',
                    ], 401);
            }
            
        }
        return $next($request);
    }
}