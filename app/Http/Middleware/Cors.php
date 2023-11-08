<?php

namespace App\Http\Middleware;

use Closure;

/**
 * Update logs
 *  - Change from $next($request)->header() to $response->headers->set() 
 *  (to fix error Call to undefined method \\StreamedResponse::header())
 */
class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST');
        $response->headers->set('Access-Control-Allow-Headers', 'Accept, X-Requested-With, Origin, Content-Type');
        return $response;
    }
}