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
}