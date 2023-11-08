<?php

namespace App\Domain\Repositories\Token;
use App\Models\User;
use App\Domain\Repositories\Contracts\TokenRepositoryInterface;
use App\Domain\Entities\Token\TokenResult;
use App\Domain\Exceptions\Exception;

class TokenRepository implements TokenRepositoryInterface{

    public function createToken($userId, $name, array $scopes = null){
        try{
            $model = User::find($userId);
            $token = $model->createToken($name, $scopes);  
            return TokenResult::create($token);
        }
        catch (\Exception $ex){
            throw new Exception("Token Creation errors ".$ex->getMessage());
        }
    }
}