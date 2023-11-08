<?php

namespace App\Utilities\Container;

use App\Utilities\Container\ContainerHelper;

trait ContainerTrait{
    /**
     * Resolve 
     */
    public function resolve($type, $params = null) {
        return ContainerHelper::getContainer()->resolve($type, $params);
    }
}