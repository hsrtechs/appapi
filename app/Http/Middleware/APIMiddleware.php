<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
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
            return $next($request);
        else
            return APIError("Failed",['Invalid accept header.'],406);
    }
}
