<?php
namespace App\Services\Auth;

use App\Domain\Adapters\User\UserAdapter;
use App\Domain\Entities\Token\TokenResult;
use App\Services\Contracts\JWTTokenServiceInterface;
use App\Domain\Entities\User\User;
use DateInterval;
use DateTime;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtTokenService implements JWTTokenServiceInterface{
    /**
     * Attempt and generate an access token
     *
     * @param User $user
     * @param array $options
     * @return TokenResult
     */
    public function generate(User $user, array $options = []): TokenResult{
        $ttl = env("JWT_TTL") ?? 60 * 24 * 1; // 2 days
        $expiredTime = now()->addDays(2);

        $adapter = (new UserAdapter())->toEloquent($user);
        $token = JWTAuth::claims($options)->setTTL($ttl)->fromUser($userModel);

        $expirationTime = $this->expirationTimeFromTTL($ttl * 60);
        return new TokenResult($token, $expirationTime);
    }
}
