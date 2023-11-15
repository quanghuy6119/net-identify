<?php

namespace App\Services\Auth;

use Illuminate\Support\Facades\Session;

class SessionManager {
    /**
     * Make refresh session
     *
     * @param string $newToken
     * @param string|null $refreshedToken
     * @return void
     */
    public static function refresh(string $newToken, ?string $refreshedToken = null) {
        $tokens = Session::get('access_tokens') ?? [];
        $tokens[] = $newToken;
        if (!$refreshedToken) $tokens = array_diff($tokens, [$refreshedToken]);

        self::regenerate();
        Session::put('access_tokens', $tokens);
    }

    /**
     * Forget specific token
     *
     * @param string $token
     * @return array
     */
    public static function forgetToken(string $token) {
        $tokens = Session::get('access_tokens') ?? [];
        $tokens = array_diff($tokens, [$token]);
        Session::put('access_tokens', $tokens);

        return $tokens;
    }

    /**
     * Get tokens
     *
     * @param string $token
     * @return array
     */
    public static function getTokens() {
        return Session::get('access_tokens') ?? [];
    }

    /**
     * Fresh new session
     *
     * @return void
     */
    public static function regenerate() {
        Session::flush();
        Session::regenerate();
        Session::regenerateToken();
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