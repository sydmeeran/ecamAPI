<?php

namespace App\Http\Middleware;

use App\Exceptions\ApiKeyException;
use Closure;

class ApiKeyMiddleware
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
        if($request->header('api-key') !== env('API_KEY')){
            throw new ApiKeyException();
        }
        return $next($request);
    }
}
