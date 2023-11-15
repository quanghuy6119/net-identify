<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\Auth\HTTPCookieManager;
use Illuminate\Support\Facades\Session;
use Tymon\JWTAuth\Facades\JWTAuth;

class JWTAuthenticateRequest
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
        $accessToken = HTTPCookieManager::getAccessToken($request);
        if ($accessToken === null || !$this->checkTokenExistInSession($accessToken)) return redirect('login');

        try {
            auth()->login(JWTAuth::setToken($accessToken)->toUser());
        } catch (\Exception $e) {
            return redirect('login');
        }
        
        return $next($request);
    }

    private function checkTokenExistInSession($accessToken) {
        if ($accessToken === null) return false;
        $accessTokens = Session::get('access_tokens') ?? [];
        foreach($accessTokens as $token) {
            if ($token === $accessToken) return true;
        }
        return false;
    }
}
