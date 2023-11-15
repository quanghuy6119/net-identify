<?php
namespace App\Services\Contracts;

use App\Domain\Entities\Token\TokenResult;

interface AuthServiceInterface{
    /**
     * Attempt to login
     *
     * @param string $email
     * @param string $password
     * @return TokenResult
     */
    public function attempt(string $email, string $password);

    /** 
     * Logout specific account
     *
     * @param string $token
     * @return void
     */
    public function logoutCurrentAccount(string $token);

    /** 
     * Logout all account
     *
     * @return void
     */
    public function logoutAllAccount();
}