<?php

namespace App\Services\Auth;

use App\Domain\Entities\Token\TokenResult;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;

class HTTPCookieManager {
    /**
     * Set access token
     *
     * @param TokenResult $token
     * @return void
     */
    public static function setAccessToken(TokenResult $token) {    
        $cookie = Cookie::make(
            'access_token', 
            $token->getAccessToken(),
            now()->diffInMinutes($token->getExpiresAt()),
            null, null, false, true
        );

        Cookie::queue($cookie);
    }

    /**
     * Get access token
     *
     * @param Request $request
     * @return TokenResult|null
     */
    public static function getAccessToken(Request $request) {
        return $request->cookie('access_token');
    }
}