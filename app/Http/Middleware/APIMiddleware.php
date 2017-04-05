<?php

namespace App\Http\Middleware;

use Closure;
use function response;

class APIMiddleware
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
        if($request->isJson() && $request->expectsJson())
        {
            return $next($request);
        }
        return response("	Invalid format: This service doesn't exist in that format.",405);
    }
}
