<?php

namespace App\Http\Middleware;

use Closure;

/**
 * Class CheckIfRequestAjax
 * @package App\Http\Middleware
 */
class CheckIfRequestAjax
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
        if(!$request->ajax()) {
            return response()->make('Access Forbidden.', 403);
        }

        return $next($request);
    }
}
