<?php

namespace App\Services\Contracts;

use App\Domain\Entities\User\User;
interface PassportServiceInterface{
    public function createToken(User $user);
}