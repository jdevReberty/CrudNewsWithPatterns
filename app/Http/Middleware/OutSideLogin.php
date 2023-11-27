<?php

namespace App\Http\Middleware;

use App\Services\RequestCurrentUriServices;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class OutSideLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {  
        $requestURIService = new RequestCurrentUriServices();
        if($requestURIService->isApiRequest($request)) {
            if(!auth()->check()) {
                return $next($request);
            }
            return response()->json([
                'status' => 403,
                'message' => "The user has already been authenticated"
            ]);
        }else {
            if (!Auth::check()) {
                return $next($request);
            }
             
            return redirect()->back();
        }
    }
}
