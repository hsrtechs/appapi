<?php

namespace App\Http\Middleware;

use App\Helpers\Session;
use Closure;
use function redirect;

class AdminMiddleware
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
        if(Session::exists('admin'))
            return $next($request);
        else
            return redirect(url('/login'));
    }
}
