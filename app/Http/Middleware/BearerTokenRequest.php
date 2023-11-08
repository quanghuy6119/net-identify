<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BearerTokenRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $this->getBearerToken($request);
        $request->request->add([
            'token' => $token
        ]);
        return $next($request);
    }
    private function getBearerToken(Request $request){
        $authorization = $request->headers->get("Authorization", '');
        $token = '';
        if (\Str::startsWith($authorization, 'Bearer ')) {
                 $token = \Str::substr($authorization, 7);
        }
        return $token;
    }
}
