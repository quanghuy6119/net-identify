<?php

namespace App\Http\Controllers\Api\Client;

use Illuminate\Http\Request;

use App\Services\Contracts\UserServiceInterface;
use App\Validation\User\UpdateUserValidator;
use App\Http\Controllers\ApiController;

class UserController extends ApiController
{
    protected UserServiceInterface $userService;

    public function __construct(UserServiceInterface $userService)
    {
        parent::__construct();
        $this->userService = $userService;
    }

    public function get(Request $request){
        return $this->userService->getByConditions($request->all(), [
            'only' => ['id', 'name']
        ]);
    }
}