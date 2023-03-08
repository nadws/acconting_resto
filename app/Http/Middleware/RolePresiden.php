<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RolePresiden
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
        return auth()->user()->id_posisi == 1 ? $next($request) : abort(403);
    }
}
