<?php

namespace App\Http\Middleware;

use App\Services\RequestCurrentUriServices;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        $requestURIService = new RequestCurrentUriServices();
        if($requestURIService->isApiRequest($request)) {
            if(!auth()->check()) {
                return response()->json('Não autorizado');
            }
        }
        if (!$request->expectsJson()) {
            return route('login.index');
        }
    }
}
