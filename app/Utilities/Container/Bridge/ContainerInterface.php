<?php

namespace App\Utilities\Container\Bridge;

/**
 * ContainerInterface defines the contract for resolving services from a container.
 *
 * Author: Fox
 */
interface ContainerInterface
{
    /**
     * Resolve a service from the container.
     *
     * @param string $type    The type or class name of the service.
     * @param mixed  $param   Optional parameter to pass to the service.
     *
     * @return mixed  An instance of the resolved service.
     */
    public function resolve($type, $param = null);
}
