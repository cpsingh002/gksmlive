<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TimeMatchMiddleware
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
        if((("09:30:00" <= now()->format('H:i:s'))&&( "18:30:00" >= now()->format('H:i:s') ))){
            return $next($request);
        }else{
            // if (Request::wantsJson()) 
            if( $request->is('api/*'))
            {
                return response()->json([
                    'status' => true,
                    'message' => 'Payment Upload timing is morining 09:30 AM to evening 06:30PM',
                ], 200);
            }
            $msg = "Payment Upload timing is morining 09:30 AM to evening 06:30PM";
            return redirect()->back()->with('status', $msg);
        }
        
    }
}
