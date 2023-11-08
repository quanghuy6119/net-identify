<?php

namespace App\Domain\Repositories\Contracts;

interface RepositoryContainerInterface{
    public function resolve($type, $params = null);
}