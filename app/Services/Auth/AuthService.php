<?php

namespace App\Services\Auth;

use App\Domain\Exceptions\InvalidInputException;
use App\Domain\Repositories\Contracts\UserRepositoryInterface;
use App\Domain\Entities\Token\TokenResult;
use App\Services\Contracts\JWTTokenServiceInterface;
use App\Services\Contracts\AuthServiceInterface;
use App\Services\Service;
use Illuminate\Support\Facades\Session;
use Hash;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService extends Service implements AuthServiceInterface
{
    /**
     * Token repository
     *
     * @var JWTTokenServiceInterface
     */
    protected JWTTokenServiceInterface $tokens;

    /**
     * User repository
     *
     * @var UserRepositoryInterface
     */
    protected UserRepositoryInterface $users;

    function __construct(UserRepositoryInterface $users, JWTTokenServiceInterface $tokens) {
        $this->users = $users;
        $this->tokens = $tokens;
    }

    /**
     * Attempt to login
     *
     * @param string $email
     * @param string $password
     * @return TokenResult
     * @throws InvalidInputException
     */
    public function attempt(string $email, string $password)
    {
        $user = $this->users->getByEmail($email);
        if(!is_null($user)) {
            if(Hash::check($password, $user->getPassword())) {
                $token = $this->tokens->generate($user);
                SessionManager::refresh($token->getAccessToken());
                HTTPCookieManager::setAccessToken($token);
                return $token;
            }
        };

        throw new InvalidInputException("Email or Password is invalid!!");
    }

    /** 
     * Logout specific account
     *
     * @param string $token
     * @return void
     */
    public function logoutCurrentAccount(string $token) 
    {
        $tokens = SessionManager::forgetToken($token);
        
        auth()->logout();
        // Implement save to backlist
        HTTPCookieManager::forgetAccessToken();
        SessionManager::regenerate();
        Session::put('access_tokens', $tokens);
    }

    /** 
     * Logout all account
     *
     * @return void
     */
    public function logoutAllAccount() 
    {
        $tokens = SessionManager::getTokens();
        // Implement save to backlist
        foreach($tokens as $token) JWTAuth::setToken($token)->invalidate();
        HTTPCookieManager::forgetAccessToken();
        Auth::logout();
    }

    public function changeAccount() {
    }
}