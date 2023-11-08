<?php

namespace App\Services;

use App\Utilities\Traits\ResponseAPI;
use App\Utilities\Container\ContainerTrait;
use App\Utilities\Traits\SerializationTrait;

class Service{
    use ResponseAPI, SerializationTrait, ContainerTrait;
}