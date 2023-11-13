<?php
namespace App\Services\Contracts;

use App\Domain\Entities\Token\TokenResult;
use App\Domain\Entities\User\User;

interface JWTTokenServiceInterface{
    /**
     * Attempt and generate an access token
     *
     * @param User $user
     * @param array $options
     * @return TokenResult
     */
    public function generate(User $user, array $options = []): TokenResult;
}