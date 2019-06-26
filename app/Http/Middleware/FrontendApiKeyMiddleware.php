<?php

namespace App\Http\Middleware;

use Closure;
use App\Exceptions\ApiKeyException;

class FrontendApiKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->header('api-key') !== env('FRONTEND_API_KEY')){
            throw new ApiKeyException();
        }
        return $next($request);
    }
}
