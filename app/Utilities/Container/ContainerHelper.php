<?php

namespace App\Utilities\Container;

use App\Utilities\Container\Bridge\ContainerInterface;
use App\Utilities\Container\LaravelContainer;

/**
 * Container Helper provides methods to get the container.
 * 
 * Author: Fox
 * 
 */
class ContainerHelper
{
    private static $instance;

    /**
     * Get the container instance.
     *
     * @return ContainerInterface  An instance of the container.
     */
    public static function getContainer(): ContainerInterface
    {
        if (self::$instance) {
            return self::$instance;
        }
        // create new instance
        self::$instance = new LaravelContainer();

        return self::$instance;
    }
}
