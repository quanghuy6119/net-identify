<?php

namespace App\Services\Auth;

use Illuminate\Support\Facades\Session;

class SessionManager {
    /**
     * Make refresh session
     *
     * @param string $newToken
     * @param string|null $refreshToken
     * @return void
     */
    public static function refresh(string $newToken, ?string $refreshToken = null) {
        $tokens = Session::get('access_tokens') ?? [];
        $tokens[] = $newToken;
        if (!$refreshToken) $tokens = array_diff($tokens, [$refreshToken]);

        Session::flush();
        Session::regenerate();
        Session::put('access_tokens', $tokens);
    }

    /**
     * Add options to session
     *
     * @param array $options
     * @return void
     */
    public static function putOptions(array $options) {
        foreach($options as $key => $value) {
            Session::put($key, $value);
        }
    }
}