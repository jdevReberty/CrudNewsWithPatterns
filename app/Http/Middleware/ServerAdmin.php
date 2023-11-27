<?php

namespace App\Http\Middleware;

use App\Services\UserServices;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\Middleware;
use Symfony\Component\HttpFoundation\Response;

class ServerAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {   
        if(UserServices::isAdmin()) {
            return $next($request);
        } 
        return redirect()->back()->withErrors(['Acesso não autorizado']);
    }
}
