<?php

namespace App\Utilities\Container;

use Illuminate\Support\Facades\App;
use App\Utilities\Container\Bridge\ContainerInterface;

/**
 * LaravelServiceContainer implements the ContainerInterface for the Laravel framework.
 *
 * Author: Fox
 */
class LaravelContainer implements ContainerInterface
{
    /**
     * Resolve a class from the Laravel service container.
     *
     * @param string $type    The type or class name of the service.
     * @param array  $params  Optional parameters to pass to the service constructor.
     *
     * @return object  An instance of the resolved service.
     */
    public function resolve($type, $params = null)
    {
        if (!$params) {
            // Resolve the class without passing any parameters
            return App::make($type);
        }

        // Resolve the class and pass the parameters to its constructor
        return App::makeWith($type, $params);
    }
}
