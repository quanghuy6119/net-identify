<?php

namespace App\Domain\Repositories\Contracts;
use App\Domain\Exceptions\Exception;

interface TokenRepositoryInterface{
    /**
     * Create a token for user by id
     *
     * @param [type] $userId
     * @param [type] $name
     * @param array|null $scopes
     * @return void
     */
    public function createToken($userId, $name, array $scopes = null);
}