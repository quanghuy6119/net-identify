<?php

namespace App\Services\Auth;

use App\Domain\Exceptions\InvalidInputException;
use App\Domain\Repositories\Contracts\UserRepositoryInterface;
use App\Domain\Entities\Token\TokenResult;
use App\Services\Contracts\JWTTokenServiceInterface;
use App\Services\Contracts\AuthServiceInterface;
use App\Services\Service;
use Hash;

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
            if(Hash::check($password, $user->getPassword())) 
                $token = $this->tokens->generate($user);
        };

        throw new InvalidInputException("Email or Password is invalid!!");
    }
}