<?php

namespace App\Http\Controllers\Api\Auth;

use App\Utilities\Container\ContainerTrait;
use App\Utilities\Traits\ResponseAPI;
use App\Utilities\Traits\SerializationTrait;
use Illuminate\Routing\Controller as BaseController;

class ApiController extends BaseController
{
    use ResponseAPI, SerializationTrait, ContainerTrait;
    public function __construct(){
        $this->middleware('auth:api');
    }
}