<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerAuthenticate
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
        if (Auth::guard('customer')->check()) {
            return $next($request);
        }
        if ($request->ajax()) {
            return response()->json(['auth' => 'STOP'], 401);
        }
        if ($request->wantsJson()) {
            return response()->json(['auth' => 'STOP'], 401);
        }
        return redirect()->back()->with('auth', 'STOP');
    }
}
