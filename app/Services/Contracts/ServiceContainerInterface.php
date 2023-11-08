<?php

namespace App\Services\Contracts;

interface ServiceContainerInterface{
    public function resolve($type, $param = null);
}