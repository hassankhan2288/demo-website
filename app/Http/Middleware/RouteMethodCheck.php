<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RouteMethodCheck
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
        if ($request->isMethod('get')) {
            if(\Auth::guard('customer')->user()){
                return redirect()->route('checkout');
            }
            return redirect()->route('home');
        }
        return $next($request);
    }
}
