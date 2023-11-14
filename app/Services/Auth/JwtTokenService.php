<?php
namespace App\Services\Auth;

use App\Domain\Adapters\User\UserAdapter;
use App\Domain\Entities\Token\TokenResult;
use App\Services\Contracts\JWTTokenServiceInterface;
use App\Domain\Entities\User\User;
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
        JWTAuth::factory()->setTTL($ttl);

        $model = (new UserAdapter())->toEloquent($user);
        $token = empty($options) ? JWTAuth::fromUser($model) : JWTAuth::claims($options)->fromUser($model);

        return new TokenResult($token, $expiredTime);
    }
}
